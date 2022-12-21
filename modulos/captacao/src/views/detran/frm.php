<div class="container-fluid"> 
      <div class="container " style="margin-top:10%;">
	  
	  <div class="alert alert-success" role="alert">
  This is a success alert—check it out!
</div>
	  
	  
        <div class="row">
            <div class="col-md-4"></div>
              <div class="col-md-4">
                  <h1 class="text-center" style="font-size: 24px;">Consulte Veículo</h1>
                  <form  action="http://10.1.1.58:9093/gpi/index.php?pg=71" method="post" style=" padding: 20px 15px">
                      <input type="hidden" name="pg"  value="70">
					  <div class="form-group">
                          <label >Placa do Veículo</label>
                          <input type="text" name="placa" class="form-control" required="">
                      </div>
                      <div class="form-group">
                          <label>Código RENAVAN</label>
                          <input type="text" name="renavam" class="form-control" required="">
                      </div>
                      <button type="submit" class="btn btn-success" style="border-radius: 35px; width: 100%;padding: 10px; ">Consultar</button>
                  </form>
              </div>
              <div class="col-md-4"></div>
          </div>
      </div>
    </div>
