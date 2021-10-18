<select class="inclusive_exclusive_vat" name="inclusive_exclusive_vat" >
                    <?php if ($this->session->userdata('SELECTED_VAT')) { ?>
                        <option value="exclusive_vat" <?= ($this->session->userdata('SELECTED_VAT') == 'exclusive_vat') ? 'selected' : '' ?>>Exclusive VAT</option>
                        <option value="inclusive_vat" <?= ($this->session->userdata('SELECTED_VAT') == 'inclusive_vat') ? 'selected' : '' ?>  >Inclusive VAT</option>
                    <?php } else { ?>
                        <option value="exclusive_vat" selected>Exclusive VAT</option>
                        <option value="inclusive_vat">Inclusive VAT</option>
                    <?php } ?>
</select>