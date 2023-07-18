<div class="row form-group m-1">
    <div class="col-12">
        <div class="terms-conditions-text terms-site">
            <input class="form-check-input" type="checkbox" name="terms_site" value="1" required/>
            <label for="terms_site">Sunt de acord cu</label>
            <a href="#" data-bs-toggle="modal" data-bs-target="#tandc" style="color: #A6CE39;"
            >
                Termenii și Condițiile acestui
            </a>
            site.
        </div>
    </div>
</div>

<script>
    $(".terms-site label").on("click", function () {
        const checkbox = $(this).prev("input[type=checkbox]");
        checkbox.prop("checked", !checkbox.prop("checked"));
    });
</script>
