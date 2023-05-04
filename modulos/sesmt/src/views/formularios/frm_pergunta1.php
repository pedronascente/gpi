<div class="form-radio nWQGrd">
  <div class="radio">
    <label><input type="radio" name="pergunta1" value="1" <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == '1') {
                                                            echo 'checked';
                                                          } ?>>Entre : 1 - 2 Horas </label>
  </div>
  <div class="radio">
    <label><input type="radio" name="pergunta1" value="2" <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == '2') {
                                                            echo 'checked';
                                                          } ?>> Entre : 2 - 3 Horas</label>
  </div>
  <div class="radio">
    <label><input type="radio" name="pergunta1" value="3" <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == '3') {
                                                            echo 'checked';
                                                          } ?>>Entre : 3 - 4 Horas </label>
  </div>
  <div class="radio">
    <label><input type="radio" name="pergunta1" value="4" <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == '4') {
                                                            echo 'checked';
                                                          } ?>> Entre : 4 - 5 Horas</label>
  </div>
  <div class="radio">
    <label><input type="radio" name="pergunta1" value="5" <?php if (isset($_SESSION['pergunta1']) && $_SESSION['pergunta1'] == '5') {
                                                            echo 'checked';
                                                          } ?>> Entre : 5 - ou mais</label>
  </div>
</div>