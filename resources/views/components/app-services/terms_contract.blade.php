<div class="row form-group m-1">
    <div class="col-12">
        <div class="terms-conditions-text">
            <input class="form-check-input" type="checkbox" value="1" name="volunteering_contract" required/>
            <label class="terms-contract" style="display: inline;">Sunt de acord cu </label>
            <a href="#" data-bs-toggle="modal" data-bs-target="#contract-modal" style="color: #A6CE39;">Contractul de voluntariat.</a>
        </div>
    </div>
</div>

<script>
    $(".terms-conditions-text .terms-contract").on("click", function () {
        const checkbox = $(this).prev("input[type=checkbox]");
        checkbox.prop("checked", !checkbox.prop("checked"));
    });
</script>
