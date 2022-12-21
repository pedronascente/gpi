<style>
  .wrapper {
    display: grid;
    grid-template-columns: 200px auto 1fr;
    grid-auto-rows: minmax(50px, auto);
    align-items: center;
    grid-column-gap: 20px;
  }
  .botao{
    background-color: #1f409c;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 25px;
    font-family: fantasy;
  }
</style>
<div class="wrapper">

  <div>  <?php
    switch ($type) {
      case 'success':
        ?>
        <div>
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve">
            <path style="fill:#6AC259;" d="M213.333,0C95.518,0,0,95.514,0,213.333s95.518,213.333,213.333,213.333
                  c117.828,0,213.333-95.514,213.333-213.333S331.157,0,213.333,0z M174.199,322.918l-93.935-93.931l31.309-31.309l62.626,62.622
                  l140.894-140.898l31.309,31.309L174.199,322.918z"/>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
          </svg>
        </div>

        <?php
        break;
      case 'warning':
        ?>
        <div>
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve">
            <g>
              <path style="fill:#FAC917;" d="M213.338,0C95.509,0,0,95.497,0,213.325c0,117.854,95.509,213.342,213.338,213.342
                    c117.82,0,213.329-95.488,213.329-213.342C426.667,95.497,331.157,0,213.338,0z M213.333,99.49
                    c14.793,0,26.786,11.994,26.786,26.786s-11.998,26.782-26.786,26.782s-26.786-11.994-26.786-26.782
                    C186.547,111.484,198.541,99.49,213.333,99.49z M260.207,327.181H166.46v-40.183h20.087v-80.358H166.46V166.46h73.664v40.179
                    v80.358h20.087v40.183H260.207z"/>
              <polygon style="fill:#FAC917;" points="325.935,394.449 419.55,419.529 394.466,325.918 	"/>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
          </svg>
        </div>
        <?php
        break;
      case 'danger':
        ?>
        <div>
          <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
               viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;" xml:space="preserve">
            <g>
              <path style="fill:#F05228;" d="M213.333,0C95.509,0,0,95.514,0,213.333s95.509,213.333,213.333,213.333
                    c117.815,0,213.333-95.514,213.333-213.333S331.149,0,213.333,0z M213.333,372.527c-87.778,0-159.194-71.411-159.194-159.194
                    S125.555,54.14,213.333,54.14s159.194,71.415,159.194,159.194S301.111,372.527,213.333,372.527z"/>

              <rect x="17.066" y="186.258" transform="matrix(-0.7071 -0.7071 0.7071 -0.7071 213.3327 515.0204)" style="fill:#F05228;" width="392.53" height="54.139"/>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
            <g>
            </g>
          </svg>
        </div>
        <?php
        break;
    }
    ?></div>  
  <div><h1 style="font-family: fantasy;">  <?php echo $msg; ?> </h1></div>
  <?php
  if (isset($callBack)) {
    ?>
    <div><a href="<?php echo $callBack; ?>" class="botao">OK</a></div>

    <?php
  } else {
    ?>
    <div><input type="button" value="OK" onclick="self.close()" class="botao"></div>
    <?php
  }
  ?>
</div>		