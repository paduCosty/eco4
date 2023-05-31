<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Netopia\Payment\Address;
use Netopia\Payment\Invoice;
use Netopia\Payment\Request\Card;
use Symfony\Component\HttpFoundation\RedirectResponse;

class NetopiaController extends Controller
{
    /**
     * all payment requests will be sent to the NETOPIA Payments server
     * SANDBOX : http://sandboxsecure.mobilpay.ro
     * LIVE : https://secure.mobilpay.ro
     */
    public $paymentUrl;
    /**
     * NETOPIA Payments is working only with Certificate. Each NETOPIA partner (merchant) has a certificate.
     * From your Admin panel you can download the Certificate.
     * is located in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
     * the var $x509FilePath is path of your certificate in your platform
     * i.e: /home/certificates/public.cer
     */
    public $x509FilePath;
    /**
     * Billing Address
     */
    public $billingAddress;
    /**
     * Shipping Address
     */
    public $shippingAddress;


    public function index(Request $request)
    {
        $donate_amount = $request->sum;

        if ($request->donate_amount) {
            $donate_amount = $request->donate_amount;
        }
        if (!$donate_amount) {
            return redirect()
                ->route('home')
                ->with('error', 'Nu ati selectat o suma!');
        }

        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $payment_url = env("NETOPIA_PAYMENT_URL");
        $this->paymentUrl = $payment_url;
        $this->x509FilePath = env("X509FILE_PATH");
        try {
            $paymentRequest = new Card();
            $paymentRequest->signature = env("MOBILE_PAY_SIGNATURE");//signature - generated by mobilpay.ro for every merchant account
            $paymentRequest->orderId = md5(uniqid(rand())); // order_id should be unique for a merchant account
            $paymentRequest->confirmUrl = url('/'); // is where mobilPay redirects the client once the payment process is finished and is MANDATORY
            $paymentRequest->returnUrl = url('/');// is where mobilPay will send the payment result and is MANDATORY

            /*
             * Invoices info
             */
            $paymentRequest->invoice = new Invoice();
            $paymentRequest->invoice->currency = 'RON';
            $paymentRequest->invoice->amount = $donate_amount;
            $paymentRequest->invoice->tokenId = null;
            $paymentRequest->invoice->details = 'Plata online cu cardul - Planteaza in Romania - Donatie # plata_id';

            /*
             * Billing Info
             */
            $this->billingAddress = new Address();
            $this->billingAddress->type = "person"; //should be "person" / "company"
            $this->billingAddress->firstName = $request->name;
            $this->billingAddress->lastName = $request->last_name;
//            $this->billingAddress->address = "Bulevardul Ion Creangă, Nr 00";
            $this->billingAddress->email = $request->email;
            $this->billingAddress->mobilePhone = $request->phone;
            $paymentRequest->invoice->setBillingAddress($this->billingAddress);

            /*
             * Shipping
             */

            $this->shippingAddress = new Address();
            $this->shippingAddress->type = "person"; //should be "person" / "company"
            $this->shippingAddress->firstName = $request->name;
            $this->shippingAddress->lastName = $request->last_name;
//            $this->shippingAddress->address = "Bulevardul Mihai Eminescu, Nr 00";
            $this->shippingAddress->email = $request->email;
            $this->shippingAddress->mobilePhone = $request->phone;
            $paymentRequest->invoice->setShippingAddress($this->shippingAddress);

            /*
             * encrypting
             */
//            dd($this->x509FilePath);
            $paymentRequest->encrypt($this->x509FilePath);

            /**
             * send the following data to NETOPIA Payments server
             * Method : POST
             * URL : $paymentUrl
             */

            $EnvKey = $paymentRequest->getEnvKey();
            $data = $paymentRequest->getEncData();

        } catch (\Exception $e) {
            return "Oops, There is a problem!";
        }

        return view('netopia_pyment.netopia', compact('EnvKey', 'data', 'payment_url'));


    }

}
