<!DOCTYPE html>
<!-- saved from url=(0046)https://wacfwd.axshare.com/espace_gratuit.html -->
<html class="gr__wacfwd_axshare_com"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">
    <title>Espace gratuit</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link href="./espace_gratuit_files/axure_rp_page.css" type="text/css" rel="stylesheet">
    <link href="./espace_gratuit_files/styles.css" type="text/css" rel="stylesheet">
    <link href="./espace_gratuit_files/styles(1).css" type="text/css" rel="stylesheet">
    <script async="" src="./espace_gratuit_files/analytics.js.download"></script><script type="text/javascript">
        AXSHARE_HOST_URL = 'http://share.axure.com';
        AXSHARE_HOST_SECURE_URL = 'https://share.axure.com';
        ACCOUNT_SERVICE_URL = 'http://accounts.axure.com';
        ACCOUNT_SERVICE_SECURE_URL = 'https://accounts.axure.com';
        ON_PREM_LDAP_ENABLED = 'false';
</script><script src="./espace_gratuit_files/jquery-1.7.1.min.js.download"></script>
    <script src="./espace_gratuit_files/jquery-ui-1.8.10.custom.min.js.download"></script>
    <script src="./espace_gratuit_files/prototypePre.js.download"></script>
    <script src="./espace_gratuit_files/document.js.download"></script>
    <script src="./espace_gratuit_files/prototypePost.js.download"></script>
    <script src="./espace_gratuit_files/data.js.download"></script>
    <script type="text/javascript">
      $axure.utils.getTransparentGifPath = function() { return 'https://d1h0x9w88ijkiq.cloudfront.net/3372/images/transparent.gif'; };
      $axure.utils.getOtherPath = function() { return 'resources/Other.html'; };
      $axure.utils.getReloadPath = function() { return '#.html'; };
    </script>
  
<script>
    $(document).ready(function(){
        $("iframe").each(function( index ) {
            var iframeSrc = $(this).attr('src') || '';
            if(iframeSrc.indexOf('http:') != -1){
                $(this).attr('scrolling', 'auto');
                $(this).css('overflow', 'auto');
                $(this).attr('src', 'https://uftnur.axshare.com/');
            }
        });
    });
</script>

  <!-- BEGIN OF WebGIS -->
  <!-- Library Leaflet -->
  <link rel="stylesheet" href="./libs/leaflet/leaflet.css" />
  <script src="./libs/leaflet/leaflet.js"></script>

  <!-- Extension Géoportail pour Leaflet -->
  <script src="./libs/GpPluginLeaflet/GpPluginLeaflet.js"></script>
  <link rel="stylesheet" href="./libs/GpPluginLeaflet/GpPluginLeaflet.css" />

  <!-- jQuery -->
  <script src="./libs/js/jquery-1.10.1.min.js"></script>
  <!-- TileLayer BetterWMS -->
  <script src="./libs/js/L.TileLayer.BetterWMS.js"></script>

  <!-- jsonQ - http://ignitersworld.com/lab/jsonQ.html -->
  <script src="./libs/js/jsonQ.min.js"></script>
  <style>
    #map {
      margin-top: 10px;
      margin-right: 10px;
      width: 650px;
      height: 260px;
      float: right;
    }
  </style>
  <script>
      function go() {
          // Search address and return the lat lon
          var str = RemoveAccents(urlParam('address'));
          addr_search(str);

          function mainFunction(myArr)
          {
              console.log(myArr);
              console.log(myArr[0].lat);
              console.log(myArr[0].lon);
              map = L.map("map").setView([myArr[0].lat,myArr[0].lon], 10); //43.911003,4.873123: lat long of Avignon
              // var lyrOSM= L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png') ;

              var lyrOSM = L.geoportalLayer.WMTS({
                  layer: "GEOGRAPHICALGRIDSYSTEMS.MAPS",
              }, { // leafletParams
                  opacity: 1
              });

              var url = 'http://localhost:8080/geoserver/ign/wms';
              var lyrCommune = L.tileLayer.betterWms(url, {
                  layers: "ign:commune_view",
                  format: 'image/png',
                  opacity: 0.8,
                  info_format: 'application/json', // Return with JSON format
                  transparent: true
              });

              map.addLayer(lyrOSM);
              map.addLayer(lyrCommune);

              // Layers switcher
              var layerSwitcher = L.geoportalControl.LayerSwitcher({
                  layers : [{
                      layer : lyrOSM,
                      config : {
                          title : "OSM",
                          description : "Couche Open Street Maps"
                      }
                  },
                      {
                          layer : lyrCommune,
                          config : {
                              title : "Commune",
                              description : "Commune on Open Street Maps"
                          }
                      }]
              });
              map.addControl(layerSwitcher);

              // Search Bar
              var searchCtrl = L.geoportalControl.SearchEngine({zoomTo : "auto"});
              map.addControl(searchCtrl);

              var latlngPoint = new L.LatLng(myArr[0].lat,myArr[0].lon);
              map.fireEvent('click', {
                  latlng: latlngPoint,
                  layerPoint: map.latLngToLayerPoint(latlngPoint),
                  containerPoint: map.latLngToContainerPoint(latlngPoint)
              });
          }

          // Search address
          function addr_search(address)
          {
              jQuery.ajax({
                  method: "GET",
                  url: "https://nominatim.openstreetmap.org/search?format=json&limit=1&q=",
                  data: {"q": address},
              }).done(function (data) {
                  console.log(data);
                  mainFunction(data);
              });
          }

          // Return url Param
          function urlParam(name){
              var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
              return results[1] || 0;
          }

          function RemoveAccents(strAccents) {
              var strAccents = strAccents.split('');
              var strAccentsOut = new Array();
              var strAccentsLen = strAccents.length;
              var accents = 'ÀÁÂÃÄÅàáâãäåÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñŠšŸÿýŽž';
              var accentsOut = "AAAAAAaaaaaaOOOOOOOooooooEEEEeeeeeCcDIIIIiiiiUUUUuuuuNnSsYyyZz";
              for (var y = 0; y < strAccentsLen; y++) {
                  if (accents.indexOf(strAccents[y]) != -1) {
                      strAccentsOut[y] = accentsOut.substr(accents.indexOf(strAccents[y]), 1);
                  } else
                      strAccentsOut[y] = strAccents[y];
              }
              strAccentsOut = strAccentsOut.join('');
              return strAccentsOut;
          }
      }

      Gp.Services.getConfig({
          apiKey : "jhyvi0fgmnuxvfv0zjzorvdn",
          onSuccess : go
      }) ;
  </script>
  <!-- END OF WebGIS -->

</head>
  <body data-gr-c-s-loaded="true">
    <div id="base" class="">

      <!-- Unnamed (Rectangle) -->
      <div id="u5625" class="ax_default box_2">
        <div id="u5625_div" class=""></div>
      </div>

      <!-- Unnamed (Rectangle) -->
      <div id="u5626" class="ax_default box_2">
        <div id="u5626_div" class=""></div>
      </div>

      <!-- Situation générale (Group) -->
      <div id="u5627" class="ax_default" data-label="Situation générale" data-left="210" data-top="99" data-width="1073" data-height="598">

        <!-- Unnamed (Rectangle) -->
        <div id="u5628" class="ax_default box_2">
          <div id="u5628_div" class=""></div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5629" class="ax_default heading_2">
          <div id="u5629_div" class=""></div>
          <div id="u5629_text" class="text " style="top: 15px; transform-origin: 531.5px 11.5px 0px;">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Situation générale</span></p>
          </div>
        </div>

        <!-- Unnamed (Vertical Line) -->
        <div id="u5630" class="ax_default line">
          <img id="u5630_img" class="img " src="./espace_gratuit_files/u1886.png">
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5631" class="ax_default heading_3">
          <div id="u5631_div" class=""></div>
          <div id="u5631_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Commune</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5632" class="ax_default heading_3">
          <div id="u5632_div" class=""></div>
          <div id="u5632_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Département</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5633" class="ax_default heading_3">
          <div id="u5633_div" class=""></div>
          <div id="u5633_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Région</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5634" class="ax_default heading_3">
          <div id="u5634_div" class=""></div>
          <div id="u5634_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Paris 11</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5635" class="ax_default heading_3">
          <div id="u5635_div" class=""></div>
          <div id="u5635_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">75</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5636" class="ax_default heading_3">
          <div id="u5636_div" class=""></div>
          <div id="u5636_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Île-de-France</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5637" class="ax_default heading_3">
          <div id="u5637_div" class=""></div>
          <div id="u5637_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Code Insee</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5638" class="ax_default heading_3">
          <div id="u5638_div" class=""></div>
          <div id="u5638_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Superficie</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5639" class="ax_default heading_3">
          <div id="u5639_div" class=""></div>
          <div id="u5639_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Maire</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5640" class="ax_default heading_3">
          <div id="u5640_div" class=""></div>
          <div id="u5640_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">75011</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5641" class="ax_default heading_3">
          <div id="u5641_div" class=""></div>
          <div id="u5641_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">3,66km2</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5642" class="ax_default heading_3">
          <div id="u5642_div" class=""></div>
          <div id="u5642_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">François Vauglin</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5643" class="ax_default heading_3">
          <div id="u5643_div" class=""></div>
          <div id="u5643_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Densité</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5644" class="ax_default heading_3">
          <div id="u5644_div" class=""></div>
          <div id="u5644_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Nuance politique</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5645" class="ax_default heading_3">
          <div id="u5645_div" class=""></div>
          <div id="u5645_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">42351,37 hab/km2</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5646" class="ax_default heading_3">
          <div id="u5646_div" class=""></div>
          <div id="u5646_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Liste Union de gauche</span></p>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5647" class="ax_default" data-left="281" data-top="436" data-width="276" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5648" class="ax_default heading_3">
            <div id="u5648_div" class=""></div>
            <div id="u5648_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Accessibilité à véhicule</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5649" class="ax_default heading_3">
            <div id="u5649_div" class=""></div>
            <div id="u5649_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Indice de déplacement piéton</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5650" class="ax_default" data-left="281" data-top="498" data-width="276" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5651" class="ax_default heading_3">
            <div id="u5651_div" class=""></div>
            <div id="u5651_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Accessibilité en Transports</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5652" class="ax_default heading_3">
            <div id="u5652_div" class=""></div>
            <div id="u5652_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Indice de déplacement piéton</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5653" class="ax_default" data-left="281" data-top="561" data-width="276" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5654" class="ax_default heading_3">
            <div id="u5654_div" class=""></div>
            <div id="u5654_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Accessibilité à pieds</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5655" class="ax_default heading_3">
            <div id="u5655_div" class=""></div>
            <div id="u5655_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Indice de déplacement piéton</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5656" class="ax_default" data-left="281" data-top="623" data-width="316" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5657" class="ax_default heading_3">
            <div id="u5657_div" class=""></div>
            <div id="u5657_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Ensoleillement</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5658" class="ax_default heading_3">
            <div id="u5658_div" class=""></div>
            <div id="u5658_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Se base sur 1754 offres des 6 derniers mois</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5659" class="ax_default box_2">
          <div id="u5659_div" class=""></div>
          <div id="u5659_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">15 %</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5660" class="ax_default box_2">
          <div id="u5660_div" class=""></div>
          <div id="u5660_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">55 %</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5661" class="ax_default box_2">
          <div id="u5661_div" class=""></div>
          <div id="u5661_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">75 %</span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5662" class="ax_default box_2">
          <div id="u5662_div" class=""></div>
          <div id="u5662_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">15 %</span></p>
          </div>
        </div>

        <!-- c17b2f44 855e 4ad9 adae 9f404d65e035 (Group) -->
        <div id="u5663" class="ax_default" data-label="c17b2f44 855e 4ad9 adae 9f404d65e035" data-left="241" data-top="446" data-width="24" data-height="17">

          <!-- Unnamed (Shape) -->
          <div id="u5664" class="ax_default icon">
            <img id="u5664_img" class="img " src="./espace_gratuit_files/u1250.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5665" class="ax_default icon">
            <img id="u5665_img" class="img " src="./espace_gratuit_files/u1251.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5666" class="ax_default icon">
            <img id="u5666_img" class="img " src="./espace_gratuit_files/u1252.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5667" class="ax_default icon">
            <img id="u5667_img" class="img " src="./espace_gratuit_files/u1253.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5668" class="ax_default icon">
            <img id="u5668_img" class="img " src="./espace_gratuit_files/u1254.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5669" class="ax_default icon">
            <img id="u5669_img" class="img " src="./espace_gratuit_files/u1255.png">
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5670" class="ax_default" data-left="242" data-top="504" data-width="24" data-height="24">

          <!-- Unnamed (Shape) -->
          <div id="u5671" class="ax_default icon">
            <img id="u5671_img" class="img " src="./espace_gratuit_files/u1257.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5672" class="ax_default icon">
            <img id="u5672_img" class="img " src="./espace_gratuit_files/u1258.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5673" class="ax_default icon">
            <img id="u5673_img" class="img " src="./espace_gratuit_files/u1259.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5674" class="ax_default icon">
            <img id="u5674_img" class="img " src="./espace_gratuit_files/u1260.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5675" class="ax_default icon">
            <img id="u5675_img" class="img " src="./espace_gratuit_files/u1261.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5676" class="ax_default icon">
            <img id="u5676_img" class="img " src="./espace_gratuit_files/u1262.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5677" class="ax_default icon">
            <img id="u5677_img" class="img " src="./espace_gratuit_files/u1263.png">
          </div>
        </div>

        <!-- 2919505d bf74 42e7 b3ec 05eb01c341b5 (Group) -->
        <div id="u5678" class="ax_default" data-label="2919505d bf74 42e7 b3ec 05eb01c341b5" data-left="246" data-top="568" data-width="17" data-height="22">

          <!-- Unnamed (Shape) -->
          <div id="u5679" class="ax_default icon">
            <img id="u5679_img" class="img " src="./espace_gratuit_files/u1265.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5680" class="ax_default icon">
            <img id="u5680_img" class="img " src="./espace_gratuit_files/u1266.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5681" class="ax_default icon">
            <img id="u5681_img" class="img " src="./espace_gratuit_files/u1267.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5682" class="ax_default icon">
            <img id="u5682_img" class="img " src="./espace_gratuit_files/u1268.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5683" class="ax_default icon">
            <img id="u5683_img" class="img " src="./espace_gratuit_files/u1269.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5684" class="ax_default icon">
            <img id="u5684_img" class="img " src="./espace_gratuit_files/u1270.png">
          </div>
        </div>

        <!-- a99aaf0c e61c 42b0 bfdf a3e5211182da (Group) -->
        <div id="u5685" class="ax_default" data-label="a99aaf0c e61c 42b0 bfdf a3e5211182da" data-left="243" data-top="638" data-width="22" data-height="23">

          <!-- Unnamed (Shape) -->
          <div id="u5686" class="ax_default icon">
            <img id="u5686_img" class="img " src="./espace_gratuit_files/u1272.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5687" class="ax_default icon">
            <img id="u5687_img" class="img " src="./espace_gratuit_files/u1273.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5688" class="ax_default icon">
            <img id="u5688_img" class="img " src="./espace_gratuit_files/u1274.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5689" class="ax_default icon">
            <img id="u5689_img" class="img " src="./espace_gratuit_files/u1275.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5690" class="ax_default icon">
            <img id="u5690_img" class="img " src="./espace_gratuit_files/u1275.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5691" class="ax_default icon">
            <img id="u5691_img" class="img " src="./espace_gratuit_files/u1277.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5692" class="ax_default icon">
            <img id="u5692_img" class="img " src="./espace_gratuit_files/u1278.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5693" class="ax_default icon">
            <img id="u5693_img" class="img " src="./espace_gratuit_files/u1279.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5694" class="ax_default icon">
            <img id="u5694_img" class="img " src="./espace_gratuit_files/u1280.png">
          </div>
        </div>

        <!-- Unnamed (Image) -->
        <div id="u5695" class="ax_default image">
          <div id="map"></div>
        </div>
        <!--
          <img id="u5695_img" class="img " src="./espace_gratuit_files/u1951.png">
        -->
        <!-- Unnamed (Rectangle) -->
        <div id="u5696" class="ax_default box_2">
          <div id="u5696_div" class=""></div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5697" class="ax_default heading_3">
          <div id="u5697_div" class=""></div>
          <div id="u5697_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;"><?php echo $_GET['address']; ?></span></p>
          </div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5698" class="ax_default box_2">
          <img id="u5698_img" class="img " src="./espace_gratuit_files/u1293.png">
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5699" class="ax_default paragraph">
          <div id="u5699_div" class=""></div>
          <div id="u5699_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Paris 11e Arrondissement est une commune située dans le département Paris (75), région Île-de-France. Son maire actuel est François VAUGLIN (Liste Union de la Gauche). Elle comptait 155 006 habitants en 2012, soit 359 de plus qu'en 2011. Ses habitants sont appelés "Parisien Parisienne".</span></p>
          </div>
        </div>
      </div>

      <!-- Bien type (Group) -->
      <div id="u5700" class="ax_default" data-label="Bien type" data-left="577" data-top="730" data-width="337" data-height="336">

        <!-- Unnamed (Rectangle) -->
        <div id="u5701" class="ax_default box_2">
          <div id="u5701_div" class=""></div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5702" class="ax_default heading_2">
          <div id="u5702_div" class=""></div>
          <div id="u5702_text" class="text " style="top: 15px; transform-origin: 163px 11.5px 0px;">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Bien type</span></p>
          </div>
        </div>

        <!-- Unnamed (Horizontal Line) -->
        <div id="u5703" class="ax_default line">
          <img id="u5703_img" class="img " src="./espace_gratuit_files/u1959.png">
        </div>

        <!-- Unnamed (Vertical Line) -->
        <div id="u5704" class="ax_default line">
          <img id="u5704_img" class="img " src="./espace_gratuit_files/u1960.png">
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5705" class="ax_default" data-left="577" data-top="864" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5706" class="ax_default heading_3">
            <div id="u5706_div" class=""></div>
            <div id="u5706_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Type de bien</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5707" class="ax_default heading_3">
            <div id="u5707_div" class=""></div>
            <div id="u5707_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Appartement</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5708" class="ax_default" data-left="746" data-top="864" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5709" class="ax_default heading_3">
            <div id="u5709_div" class=""></div>
            <div id="u5709_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Prix moyen</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5710" class="ax_default heading_3">
            <div id="u5710_div" class=""></div>
            <div id="u5710_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">185 031 €</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5711" class="ax_default" data-left="577" data-top="1005" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5712" class="ax_default heading_3">
            <div id="u5712_div" class=""></div>
            <div id="u5712_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Nombre de pièces</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5713" class="ax_default heading_3">
            <div id="u5713_div" class=""></div>
            <div id="u5713_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">2 pièces</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5714" class="ax_default" data-left="746" data-top="999" data-width="168" data-height="53">

          <!-- Unnamed (Rectangle) -->
          <div id="u5715" class="ax_default heading_3">
            <div id="u5715_div" class=""></div>
            <div id="u5715_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Durée de mise</span></p><p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">en vente</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5716" class="ax_default heading_3">
            <div id="u5716_div" class=""></div>
            <div id="u5716_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">186 jours</span></p>
            </div>
          </div>
        </div>

        <!-- dae3fcd9 d907 4278 93e8 0b5c1b5e398c (Group) -->
        <div id="u5717" class="ax_default" data-label="dae3fcd9 d907 4278 93e8 0b5c1b5e398c" data-left="637" data-top="944" data-width="35" data-height="35">

          <!-- Unnamed (Shape) -->
          <div id="u5718" class="ax_default icon">
            <img id="u5718_img" class="img " src="./espace_gratuit_files/u1227.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5719" class="ax_default icon">
            <img id="u5719_img" class="img " src="./espace_gratuit_files/u1228.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5720" class="ax_default icon">
            <img id="u5720_img" class="img " src="./espace_gratuit_files/u1229.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5721" class="ax_default icon">
            <img id="u5721_img" class="img " src="./espace_gratuit_files/u1230.png">
          </div>
        </div>

        <!-- Unnamed (Shape) -->
        <div id="u5722" class="ax_default icon">
          <img id="u5722_img" class="img " src="./espace_gratuit_files/u1231.png">
        </div>

        <!-- bff95797 783e 4df6 aa59 6feaedf180a5 (Group) -->
        <div id="u5723" class="ax_default" data-label="bff95797 783e 4df6 aa59 6feaedf180a5" data-left="809" data-top="944" data-width="35" data-height="35">

          <!-- Unnamed (Shape) -->
          <div id="u5724" class="ax_default icon">
            <img id="u5724_img" class="img " src="./espace_gratuit_files/u1233.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5725" class="ax_default icon">
            <img id="u5725_img" class="img " src="./espace_gratuit_files/u1234.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5726" class="ax_default icon">
            <img id="u5726_img" class="img " src="./espace_gratuit_files/u1235.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5727" class="ax_default icon">
            <img id="u5727_img" class="img " src="./espace_gratuit_files/u1236.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5728" class="ax_default icon">
            <img id="u5728_img" class="img " src="./espace_gratuit_files/u1237.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5729" class="ax_default icon">
            <img id="u5729_img" class="img " src="./espace_gratuit_files/u1238.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5730" class="ax_default icon">
            <img id="u5730_img" class="img " src="./espace_gratuit_files/u1239.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5731" class="ax_default icon">
            <img id="u5731_img" class="img " src="./espace_gratuit_files/u1240.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5732" class="ax_default icon">
            <img id="u5732_img" class="img " src="./espace_gratuit_files/u1241.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5733" class="ax_default icon">
            <img id="u5733_img" class="img " src="./espace_gratuit_files/u1242.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5734" class="ax_default icon">
            <img id="u5734_img" class="img " src="./espace_gratuit_files/u1243.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5735" class="ax_default icon">
            <img id="u5735_img" class="img " src="./espace_gratuit_files/u1244.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5736" class="ax_default icon">
            <img id="u5736_img" class="img " src="./espace_gratuit_files/u1245.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5737" class="ax_default icon">
            <img id="u5737_img" class="img " src="./espace_gratuit_files/u1246.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5738" class="ax_default icon">
            <img id="u5738_img" class="img " src="./espace_gratuit_files/u1247.png">
          </div>
        </div>

        <!-- Unnamed (Shape) -->
        <div id="u5739" class="ax_default icon">
          <img id="u5739_img" class="img " src="./espace_gratuit_files/u1287.png">
        </div>
      </div>

      <!-- Habitant type (Group) -->
      <div id="u5740" class="ax_default" data-label="Habitant type" data-left="947" data-top="730" data-width="337" data-height="336">

        <!-- Unnamed (Rectangle) -->
        <div id="u5741" class="ax_default box_2">
          <div id="u5741_div" class=""></div>
        </div>

        <!-- Unnamed (Rectangle) -->
        <div id="u5742" class="ax_default heading_2">
          <div id="u5742_div" class=""></div>
          <div id="u5742_text" class="text " style="top: 15px; transform-origin: 163px 11.5px 0px;">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Habitant type</span></p>
          </div>
        </div>

        <!-- Unnamed (Horizontal Line) -->
        <div id="u5743" class="ax_default line">
          <img id="u5743_img" class="img " src="./espace_gratuit_files/u1959.png">
        </div>

        <!-- Unnamed (Vertical Line) -->
        <div id="u5744" class="ax_default line">
          <img id="u5744_img" class="img " src="./espace_gratuit_files/u1960.png">
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5745" class="ax_default" data-left="947" data-top="864" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5746" class="ax_default heading_3">
            <div id="u5746_div" class=""></div>
            <div id="u5746_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Age</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5747" class="ax_default heading_3">
            <div id="u5747_div" class=""></div>
            <div id="u5747_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">35 à 45 ans</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5748" class="ax_default" data-left="1116" data-top="854" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5749" class="ax_default heading_3">
            <div id="u5749_div" class=""></div>
            <div id="u5749_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">CSP</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5750" class="ax_default heading_3">
            <div id="u5750_div" class=""></div>
            <div id="u5750_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Profession intermédiaire</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5751" class="ax_default" data-left="947" data-top="1005" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5752" class="ax_default heading_3">
            <div id="u5752_div" class=""></div>
            <div id="u5752_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Revenus</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5753" class="ax_default heading_3">
            <div id="u5753_div" class=""></div>
            <div id="u5753_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">45 - 80 000 €</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Group) -->
        <div id="u5754" class="ax_default" data-left="1116" data-top="1005" data-width="168" data-height="37">

          <!-- Unnamed (Rectangle) -->
          <div id="u5755" class="ax_default heading_3">
            <div id="u5755_div" class=""></div>
            <div id="u5755_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Etat matrimonial</span></p>
            </div>
          </div>

          <!-- Unnamed (Rectangle) -->
          <div id="u5756" class="ax_default heading_3">
            <div id="u5756_div" class=""></div>
            <div id="u5756_text" class="text ">
              <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Marié</span></p>
            </div>
          </div>
        </div>

        <!-- Unnamed (Shape) -->
        <div id="u5757" class="ax_default icon">
          <img id="u5757_img" class="img " src="./espace_gratuit_files/u1248.png">
        </div>

        <!-- 52c5109c 4504 4847 acf0 c9a3e3dc6513 (Group) -->
        <div id="u5758" class="ax_default" data-label="52c5109c 4504 4847 acf0 c9a3e3dc6513" data-left="1012" data-top="809" data-width="36" data-height="35">

          <!-- Unnamed (Shape) -->
          <div id="u5759" class="ax_default icon">
            <img id="u5759_img" class="img " src="./espace_gratuit_files/u1282.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5760" class="ax_default icon">
            <img id="u5760_img" class="img " src="./espace_gratuit_files/u1283.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5761" class="ax_default icon">
            <img id="u5761_img" class="img " src="./espace_gratuit_files/u1284.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5762" class="ax_default icon">
            <img id="u5762_img" class="img " src="./espace_gratuit_files/u1285.png">
          </div>

          <!-- Unnamed (Shape) -->
          <div id="u5763" class="ax_default icon">
            <img id="u5763_img" class="img " src="./espace_gratuit_files/u1286.png">
          </div>
        </div>

        <!-- Unnamed (Shape) -->
        <div id="u5764" class="ax_default icon">
          <img id="u5764_img" class="img " src="./espace_gratuit_files/u1288.png">
        </div>

        <!-- Unnamed (Shape) -->
        <div id="u5765" class="ax_default icon">
          <img id="u5765_img" class="img " src="./espace_gratuit_files/u1289.png">
        </div>
      </div>

      <!-- Situation particulière (Group) -->
      <div id="u5766" class="ax_default" data-label="Situation particulière" data-left="210" data-top="730" data-width="334" data-height="53">

        <!-- Unnamed (Rectangle) -->
        <div id="u5767" class="ax_default heading_2">
          <div id="u5767_div" class=""></div>
          <div id="u5767_text" class="text " style="top: 15px; transform-origin: 162px 11.5px 0px;">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Situation particulière</span></p>
          </div>
        </div>
      </div>

      <!-- Barre titre (Group) -->
      <div id="u5768" class="ax_default" data-label="Barre titre" data-left="0" data-top="0" data-width="0" data-height="0">

        <!-- Fond titre (Dynamic Panel) -->
        <div id="u5769" class="ax_default" data-label="Fond titre" style="z-index: 1001; left: 0px; width: 1349px;">
          <div id="u5769_state0" class="panel_state" data-label="State1" style="width: 1349px;">
            <div id="u5769_state0_content" class="panel_state_content" style="margin-left: 180px;">

              <!-- Unnamed (Rectangle) -->
              <div id="u5770" class="ax_default box_2">
                <div id="u5770_div" class=""></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Titre page (Dynamic Panel) -->
        <div id="u5771" class="ax_default" data-label="Titre page" style="z-index: 1002;">
          <div id="u5771_state0" class="panel_state" data-label="State1" style="">
            <div id="u5771_state0_content" class="panel_state_content">

              <!-- Unnamed (Rectangle) -->
              <div id="u5772" class="ax_default paragraph">
                <div id="u5772_div" class=""></div>
                <div id="u5772_text" class="text ">
                  <p style="font-size:28px;"><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;font-weight:700;">Synthèse</span></p><p style="font-size:14px;"><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;font-weight:400;color:#666666;"><?php echo $_GET['address']; ?></span></p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Unnamed (Dynamic Panel) -->
        <div id="u5773" class="ax_default" style="z-index: 1003; left: 0px; width: 1349px;">
          <div id="u5773_state0" class="panel_state" data-label="State1" style="width: 1349px;">
            <div id="u5773_state0_content" class="panel_state_content" style="margin-left: 180px;">

              <!-- Unnamed (Horizontal Line) -->
              <div id="u5774" class="ax_default line">
                <img id="u5774_img" class="img " src="./espace_gratuit_files/u2044.png">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Colonne menu (Dynamic Panel) -->
      <div id="u5775" class="ax_default" data-label="Colonne menu" style="z-index: 1004;">
        <div id="u5775_state0" class="panel_state" data-label="Menu" style="">
          <div id="u5775_state0_content" class="panel_state_content">

            <!-- Unnamed (Rectangle) -->
            <div id="u5776" class="ax_default box_2">
              <div id="u5776_div" class=""></div>
            </div>

            <!-- Menu (Dynamic Panel) -->
            <div id="u5777" class="ax_default" data-label="Menu" style="z-index: 1005;">
              <div id="u5777_state0" class="panel_state" data-label="State1" style="">
                <div id="u5777_state0_content" class="panel_state_content">

                  <!-- Unnamed (Group) -->
                  <div id="u5778" class="ax_default" data-left="0" data-top="294" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5779" class="ax_default label">
                      <div id="u5779_div" class="" tabindex="0"></div>
                      <div id="u5779_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Expertise prix</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5780" class="ax_default label">
                      <div id="u5780_div" class=""></div>
                      <div id="u5780_text" class="text ">
                        <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">€</span></p>
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5781" class="ax_default" data-left="0" data-top="110" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5782" class="ax_default label">
                      <div id="u5782_div" class="" tabindex="0"></div>
                      <div id="u5782_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Données</span></p>
                      </div>
                    </div>

                    <!-- 1d6298fa dff5 427d b3cc 48cdba041b9e (Group) -->
                    <div id="u5783" class="ax_default" data-label="1d6298fa dff5 427d b3cc 48cdba041b9e" data-left="10" data-top="120" data-width="20" data-height="20">

                      <!-- Unnamed (Shape) -->
                      <div id="u5784" class="ax_default icon">
                        <img id="u5784_img" class="img " src="./espace_gratuit_files/u2054.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5785" class="ax_default icon">
                        <img id="u5785_img" class="img " src="./espace_gratuit_files/u2055.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5786" class="ax_default icon">
                        <img id="u5786_img" class="img " src="./espace_gratuit_files/u2056.png">
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5787" class="ax_default" data-left="0" data-top="238" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5788" class="ax_default label">
                      <div id="u5788_div" class="" tabindex="0"></div>
                      <div id="u5788_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Votre bien</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Shape) -->
                    <div id="u5789" class="ax_default icon">
                      <img id="u5789_img" class="img " src="./espace_gratuit_files/u5789.png">
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5790" class="ax_default" data-left="0" data-top="347" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5791" class="ax_default label">
                      <div id="u5791_div" class="" tabindex="0"></div>
                      <div id="u5791_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Risques / Urba.</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Shape) -->
                    <div id="u5792" class="ax_default icon">
                      <img id="u5792_img" class="img " src="./espace_gratuit_files/u5792.png">
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5793" class="ax_default" data-left="0" data-top="54" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5794" class="ax_default label">
                      <div id="u5794_div" class="" tabindex="0"></div>
                      <div id="u5794_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p id="cache2" style=""><span id="cache3" style="">Marché immobilier</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Shape) -->
                    <div id="u5795" class="ax_default icon">
                      <img id="u5795_img" class="img" src="./espace_gratuit_files/u2065.png">
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5796" class="ax_default" data-left="0" data-top="454" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5797" class="ax_default label">
                      <div id="u5797_div" class="" tabindex="0"></div>
                      <div id="u5797_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Galerie Photos</span></p>
                      </div>
                    </div>

                    <!-- a23ca8ff 26be 4009 8665 ca5f924f84f0 (Group) -->
                    <div id="u5798" class="ax_default" data-label="a23ca8ff 26be 4009 8665 ca5f924f84f0" data-left="9" data-top="465" data-width="20" data-height="18">

                      <!-- Unnamed (Ellipse) -->
                      <div id="u5799" class="ax_default icon">
                        <img id="u5799_img" class="img " src="./espace_gratuit_files/u5799.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5800" class="ax_default icon">
                        <img id="u5800_img" class="img " src="./espace_gratuit_files/u5800.png">
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5801" class="ax_default" data-left="0" data-top="0" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5802" class="ax_default label selected">
                      <div id="u5802_div" class="selected" tabindex="0"></div>
                      <div id="u5802_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p id="cache0" style=""><span id="cache1" style="font-family: Raleway-Regular, Raleway; color: rgb(255, 255, 255);">Synthèse</span></p>
                      </div>
                    </div>

                    <!-- 484e626a 9073 4463 a2b5 0c9af0e4a9c4 (Group) -->
                    <div id="u5803" class="ax_default" data-label="484e626a 9073 4463 a2b5 0c9af0e4a9c4" data-left="10" data-top="10" data-width="20" data-height="20">

                      <!-- Unnamed (Shape) -->
                      <div id="u5804" class="ax_default icon selected">
                        <img id="u5804_img" class="img selected" src="./espace_gratuit_files/u2074_mouseover.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5805" class="ax_default icon selected">
                        <img id="u5805_img" class="img selected" src="./espace_gratuit_files/u2075_mouseover.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5806" class="ax_default icon selected">
                        <img id="u5806_img" class="img selected" src="./espace_gratuit_files/u2076_mouseover.png">
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5807" class="ax_default" data-left="0" data-top="401" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5808" class="ax_default label">
                      <div id="u5808_div" class="" tabindex="0"></div>
                      <div id="u5808_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Recommandations</span></p>
                      </div>
                    </div>

                    <!-- 6d705bde 511c 4349 9a5b 897c20d6200c (Group) -->
                    <div id="u5809" class="ax_default" data-label="6d705bde 511c 4349 9a5b 897c20d6200c" data-left="9" data-top="412" data-width="20" data-height="18">

                      <!-- Unnamed (Shape) -->
                      <div id="u5810" class="ax_default icon">
                        <img id="u5810_img" class="img " src="./espace_gratuit_files/u5810.png">
                      </div>

                      <!-- Unnamed (Shape) -->
                      <div id="u5811" class="ax_default icon">
                        <img id="u5811_img" class="img " src="./espace_gratuit_files/u5811.png">
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5812" class="ax_default" data-left="0" data-top="509" data-width="180" data-height="40" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5813" class="ax_default label">
                      <div id="u5813_div" class="" tabindex="0"></div>
                      <div id="u5813_text" class="text " style="top: 12px; transform-origin: 50px 8px 0px;">
                        <p><span>Services</span></p>
                      </div>
                    </div>

                    <!-- Rounded_1_ (Group) -->
                    <div id="u5814" class="ax_default" data-label="Rounded_1_" data-left="9" data-top="519" data-width="20" data-height="21">

                      <!-- Unnamed (Shape) -->
                      <div id="u5815" class="ax_default icon">
                        <img id="u5815_img" class="img " src="./espace_gratuit_files/u5815.png">
                      </div>
                    </div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5816" class="ax_default label">
                    <div id="u5816_div" class=""></div>
                    <div id="u5816_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Découvrez les services Ooftop Premium</span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Unnamed (SVG) -->
            <div id="u5817" class="ax_default image">
              <a href="index.php"><img id="u5817_img" class="img " src="./espace_gratuit_files/u2086.svg"></a>
            </div>

            <!-- Bas menu (Dynamic Panel) -->
            <div id="u5818" class="ax_default" data-label="Bas menu">
              <div id="u5818_state0" class="panel_state" data-label="State1" style="">
                <div id="u5818_state0_content" class="panel_state_content">
                </div>
              </div>
            </div>

            <!-- Compte + déconnexion (Dynamic Panel) -->
            <div id="u5819" class="ax_default" data-label="Compte + déconnexion" style="z-index: 1006;">
              <div id="u5819_state0" class="panel_state" data-label="State1" style="">
                <div id="u5819_state0_content" class="panel_state_content">

                  <!-- Unnamed (Group) -->
                  <div id="u5820" class="ax_default" data-left="3" data-top="0" data-width="89" data-height="14" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5821" class="ax_default label">
                      <div id="u5821_div" class="" tabindex="0"></div>
                      <div id="u5821_text" class="text " style="left: 0px; width: 67px; transform-origin: 33.5px 6.5px 0px;">
                        <p><span>Mon compte</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Shape) -->
                    <div id="u5822" class="ax_default icon">
                      <img id="u5822_img" class="img " src="./espace_gratuit_files/u2091.png">
                    </div>
                  </div>

                  <!-- Unnamed (Group) -->
                  <div id="u5823" class="ax_default" data-left="0" data-top="29" data-width="94" data-height="14" style="cursor: pointer;">

                    <!-- Unnamed (Rectangle) -->
                    <div id="u5824" class="ax_default label">
                      <div id="u5824_div" class="" tabindex="0"></div>
                      <div id="u5824_text" class="text " style="left: 0px; width: 69px; transform-origin: 34.5px 6.5px 0px;">
                        <p><span>Déconnexion</span></p>
                      </div>
                    </div>

                    <!-- Unnamed (Shape) -->
                    <div id="u5825" class="ax_default icon">
                      <img id="u5825_img" class="img " src="./espace_gratuit_files/u2094.png">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Unnamed (Horizontal Line) -->
            <div id="u5826" class="ax_default line">
              <img id="u5826_img" class="img " src="./espace_gratuit_files/u2095.png">
            </div>

            <!-- Unnamed (Horizontal Line) -->
            <div id="u5827" class="ax_default line">
              <img id="u5827_img" class="img " src="./espace_gratuit_files/u2096.png">
            </div>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5828" class="ax_default" data-left="210" data-top="783" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5829" class="ax_default heading_3">
          <div id="u5829_div" class=""></div>
          <div id="u5829_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Secteur</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5830" class="ax_default" data-left="400" data-top="783" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5831" class="ax_default heading_3">
          <div id="u5831_div" class=""></div>
          <div id="u5831_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Calme</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5832" class="ax_default" data-left="210" data-top="830" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5833" class="ax_default heading_3">
          <div id="u5833_div" class=""></div>
          <div id="u5833_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Quartier</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5834" class="ax_default" data-left="400" data-top="830" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5835" class="ax_default heading_3">
          <div id="u5835_div" class=""></div>
          <div id="u5835_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Résidentiel</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5836" class="ax_default" data-left="210" data-top="877" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5837" class="ax_default heading_3">
          <div id="u5837_div" class=""></div>
          <div id="u5837_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Type d'habitation</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5838" class="ax_default" data-left="400" data-top="877" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5839" class="ax_default heading_3">
          <div id="u5839_div" class=""></div>
          <div id="u5839_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Appartement</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5840" class="ax_default" data-left="210" data-top="925" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5841" class="ax_default heading_3">
          <div id="u5841_div" class=""></div>
          <div id="u5841_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Qualité de l'emplacement</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5842" class="ax_default" data-left="400" data-top="925" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5843" class="ax_default heading_3">
          <div id="u5843_div" class=""></div>
          <div id="u5843_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Agréable</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5844" class="ax_default" data-left="210" data-top="972" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5845" class="ax_default heading_3">
          <div id="u5845_div" class=""></div>
          <div id="u5845_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Qualité économique et démographique</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5846" class="ax_default" data-left="400" data-top="972" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5847" class="ax_default heading_3">
          <div id="u5847_div" class=""></div>
          <div id="u5847_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Dynamique</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5848" class="ax_default" data-left="210" data-top="1019" data-width="190" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5849" class="ax_default heading_3">
          <div id="u5849_div" class=""></div>
          <div id="u5849_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Densité d'habitat</span></p>
          </div>
        </div>
      </div>

      <!-- Unnamed (Group) -->
      <div id="u5850" class="ax_default" data-left="400" data-top="1019" data-width="144" data-height="47">

        <!-- Unnamed (Rectangle) -->
        <div id="u5851" class="ax_default heading_3">
          <div id="u5851_div" class=""></div>
          <div id="u5851_text" class="text ">
            <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Diffus</span></p>
          </div>
        </div>
      </div>

      <!-- BOUTON OFFRE (Dynamic Panel) -->
      <div id="u5852" class="ax_default" data-label="BOUTON OFFRE" tabindex="0" style="z-index: 1007; cursor: pointer;">
        <div id="u5852_state0" class="panel_state" data-label="State1" style="">
          <div id="u5852_state0_content" class="panel_state_content">

            <!-- Unnamed (Rectangle) -->
            <div id="u5853" class="ax_default primary_button">
              <div id="u5853_div" class=""></div>
              <div id="u5853_text" class="text " style="top: 8px; transform-origin: 113.5px 15.5px 0px;">
                <p><span style="font-family:&#39;Raleway-Medium&#39;, &#39;Raleway Medium&#39;, &#39;Raleway&#39;;">Passer à l'offre Ooftop Premium pour 29,90 €</span></p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Opacité lightbox (Dynamic Panel) -->
      <div id="u5854" class="ax_default ax_default_hidden" data-label="Opacité lightbox" style="display:none; visibility: hidden">
        <div id="u5854_state0" class="panel_state" data-label="State1" style="">
          <div id="u5854_state0_content" class="panel_state_content">

            <!-- Unnamed (Rectangle) -->
            <div id="u5855" class="ax_default box_3">
              <div id="u5855_div" class=""></div>
            </div>
          </div>
        </div>
      </div>

      <!-- lighbox (Dynamic Panel) -->
      <div id="u5856" class="ax_default ax_default_hidden" data-label="lighbox" style="display: none; visibility: hidden; z-index: 1008;">
        <div id="u5856_state0" class="panel_state" data-label="step 1" style="">
          <div id="u5856_state0_content" class="panel_state_content">

            <!-- Unnamed (Rectangle) -->
            <div id="u5857" class="ax_default box_2">
              <div id="u5857_div" class=""></div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5858" class="ax_default primary_button" style="cursor: pointer;">
              <div id="u5858_div" class="" tabindex="0"></div>
              <div id="u5858_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Créer mon compte</span></p>
              </div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5859" class="ax_default heading_2">
              <div id="u5859_div" class=""></div>
              <div id="u5859_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Créez votre compte Ooftop et accédez à l'ensemble des fonctionnalités pour 29,90 €</span></p>
              </div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5860" class="ax_default heading_1">
              <div id="u5860_div" class=""></div>
              <div id="u5860_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Nom</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5861" class="ax_default text_field">
              <input id="u5861_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5862" class="ax_default heading_1">
              <div id="u5862_div" class=""></div>
              <div id="u5862_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Prénom</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5863" class="ax_default text_field">
              <input id="u5863_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5864" class="ax_default heading_1">
              <div id="u5864_div" class=""></div>
              <div id="u5864_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Adresse email</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5865" class="ax_default text_field">
              <input id="u5865_input" type="email" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5866" class="ax_default heading_1">
              <div id="u5866_div" class=""></div>
              <div id="u5866_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Téléphone</span></p>
              </div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5867" class="ax_default heading_1">
              <div id="u5867_div" class=""></div>
              <div id="u5867_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Adresse postale</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5868" class="ax_default text_field">
              <input id="u5868_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5869" class="ax_default heading_1">
              <div id="u5869_div" class=""></div>
              <div id="u5869_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Code postal</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5870" class="ax_default text_field">
              <input id="u5870_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5871" class="ax_default heading_1">
              <div id="u5871_div" class=""></div>
              <div id="u5871_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Ville</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5872" class="ax_default text_field">
              <input id="u5872_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5873" class="ax_default heading_1">
              <div id="u5873_div" class=""></div>
              <div id="u5873_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Civilité</span></p>
              </div>
            </div>

            <!-- 18/18 - choix 1 (Rectangle) -->
            <div id="u5874" class="ax_default box_1" data-label="18/18 - choix 1" style="cursor: pointer;">
              <div id="u5874_div" class="" tabindex="0"></div>
              <div id="u5874_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Mme</span></p>
              </div>
            </div>

            <!-- 18/18 - choix 2 (Rectangle) -->
            <div id="u5875" class="ax_default box_1" data-label="18/18 - choix 2" style="cursor: pointer;">
              <div id="u5875_div" class="" tabindex="0"></div>
              <div id="u5875_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">M.</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5876" class="ax_default text_field">
              <input id="u5876_input" type="tel" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5877" class="ax_default heading_1">
              <div id="u5877_div" class=""></div>
              <div id="u5877_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">(Champ optionnel)</span></p>
              </div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5878" class="ax_default heading_1">
              <div id="u5878_div" class=""></div>
              <div id="u5878_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Mot de passe</span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5879" class="ax_default text_field">
              <input id="u5879_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5880" class="ax_default heading_1">
              <div id="u5880_div" class=""></div>
              <div id="u5880_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Répéter le mot de passe</span></p><p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;"><br></span></p>
              </div>
            </div>

            <!-- Unnamed (Text Field) -->
            <div id="u5881" class="ax_default text_field">
              <input id="u5881_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
            </div>
          </div>
        </div>
        <div id="u5856_state1" class="panel_state" data-label="step 2" style="visibility: hidden; display: none;">
          <div id="u5856_state1_content" class="panel_state_content">

            <!-- Unnamed (Rectangle) -->
            <div id="u5882" class="ax_default box_2">
              <div id="u5882_div" class=""></div>
            </div>

            <!-- Unnamed (Rectangle) -->
            <div id="u5883" class="ax_default heading_2">
              <div id="u5883_div" class=""></div>
              <div id="u5883_text" class="text ">
                <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Choisissez un moyen de paiement</span></p>
              </div>
            </div>

            <!-- 1/18 - choix 1 (Group) -->
            <div id="u5884" class="ax_default" data-label="1/18 - choix 1" data-left="38" data-top="106" data-width="142" data-height="85" style="cursor: pointer;">

              <!-- Unnamed (Rectangle) -->
              <div id="u5885" class="ax_default box_1">
                <div id="u5885_div" class="" tabindex="0"></div>
                <div id="u5885_text" class="text ">
                  <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">par carte bancaire</span></p>
                </div>
              </div>

              <!-- 66a688ef 54ca 4ff7 8396 6bfdc0bf5903 (Group) -->
              <div id="u5886" class="ax_default" data-label="66a688ef 54ca 4ff7 8396 6bfdc0bf5903" data-left="79" data-top="115" data-width="61" data-height="42">

                <!-- Unnamed (Shape) -->
                <div id="u5887" class="ax_default icon">
                  <img id="u5887_img" class="img " src="./espace_gratuit_files/u1808.png">
                </div>

                <!-- Unnamed (Rectangle) -->
                <div id="u5888" class="ax_default icon">
                  <div id="u5888_div" class=""></div>
                </div>

                <!-- Unnamed (Rectangle) -->
                <div id="u5889" class="ax_default icon">
                  <div id="u5889_div" class=""></div>
                </div>
              </div>
            </div>

            <!-- 1/18 - choix 2 (Group) -->
            <div id="u5890" class="ax_default" data-label="1/18 - choix 2" data-left="209" data-top="106" data-width="142" data-height="85" style="cursor: pointer;">

              <!-- Unnamed (Rectangle) -->
              <div id="u5891" class="ax_default box_1">
                <div id="u5891_div" class="" tabindex="0"></div>
                <div id="u5891_text" class="text ">
                  <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">par Paypal</span></p>
                </div>
              </div>

              <!-- Unnamed (Group) -->
              <div id="u5892" class="ax_default" data-left="230" data-top="124" data-width="101" data-height="27">

                <!-- XMLID_12_ (Shape) -->
                <div id="u5893" class="ax_default icon" data-label="XMLID_12_">
                  <img id="u5893_img" class="img " src="./espace_gratuit_files/xmlid_12__u1814.png">
                </div>

                <!-- XMLID_9_ (Shape) -->
                <div id="u5894" class="ax_default icon" data-label="XMLID_9_">
                  <img id="u5894_img" class="img " src="./espace_gratuit_files/xmlid_9__u1815.png">
                </div>

                <!-- XMLID_8_ (Shape) -->
                <div id="u5895" class="ax_default icon" data-label="XMLID_8_">
                  <img id="u5895_img" class="img " src="./espace_gratuit_files/xmlid_8__u1816.png">
                </div>

                <!-- XMLID_5_ (Shape) -->
                <div id="u5896" class="ax_default icon" data-label="XMLID_5_">
                  <img id="u5896_img" class="img " src="./espace_gratuit_files/xmlid_5__u1817.png">
                </div>

                <!-- XMLID_2_ (Shape) -->
                <div id="u5897" class="ax_default icon" data-label="XMLID_2_">
                  <img id="u5897_img" class="img " src="./espace_gratuit_files/xmlid_2__u1818.png">
                </div>

                <!-- XMLID_1_ (Shape) -->
                <div id="u5898" class="ax_default icon" data-label="XMLID_1_">
                  <img id="u5898_img" class="img " src="./espace_gratuit_files/xmlid_1__u1819.png">
                </div>
              </div>
            </div>

            <!-- 1/18 - choix 3 (Group) -->
            <div id="u5899" class="ax_default" data-label="1/18 - choix 3" data-left="380" data-top="106" data-width="142" data-height="85" style="cursor: pointer;">

              <!-- Unnamed (Rectangle) -->
              <div id="u5900" class="ax_default box_1">
                <div id="u5900_div" class="" tabindex="0"></div>
                <div id="u5900_text" class="text ">
                  <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">par SMS</span></p>
                </div>
              </div>

              <!-- c18a3868 e0b4 4ef8 9180 24699e706aca (Group) -->
              <div id="u5901" class="ax_default" data-label="c18a3868 e0b4 4ef8 9180 24699e706aca" data-left="425" data-top="113" data-width="52" data-height="45">

                <!-- Unnamed (Shape) -->
                <div id="u5902" class="ax_default icon">
                  <img id="u5902_img" class="img " src="./espace_gratuit_files/u1823.png">
                </div>

                <!-- Unnamed (Shape) -->
                <div id="u5903" class="ax_default icon">
                  <img id="u5903_img" class="img " src="./espace_gratuit_files/u1824.png">
                </div>

                <!-- Unnamed (Shape) -->
                <div id="u5904" class="ax_default icon">
                  <img id="u5904_img" class="img " src="./espace_gratuit_files/u1825.png">
                </div>

                <!-- Unnamed (Shape) -->
                <div id="u5905" class="ax_default icon">
                  <img id="u5905_img" class="img " src="./espace_gratuit_files/u1826.png">
                </div>
              </div>
            </div>

            <!-- Formulaires + bouton payer (Dynamic Panel) -->
            <div id="u5906" class="ax_default" data-label="Formulaires + bouton payer">
              <div id="u5906_state0" class="panel_state" data-label="Bouton seul" style="">
                <div id="u5906_state0_content" class="panel_state_content">
                </div>
              </div>
              <div id="u5906_state1" class="panel_state" data-label="CB" style="visibility: hidden; display: none;">
                <div id="u5906_state1_content" class="panel_state_content">

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5907" class="ax_default box_2">
                    <div id="u5907_div" class=""></div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5908" class="ax_default box_1">
                    <div id="u5908_div" class=""></div>
                  </div>

                  <!-- Bouton ajouter détails (Rectangle) -->
                  <div id="u5909" class="ax_default primary_button" data-label="Bouton ajouter détails" style="cursor: pointer;">
                    <div id="u5909_div" class="" tabindex="0"></div>
                    <div id="u5909_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Payer 79,00 €</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5910" class="ax_default label">
                    <div id="u5910_div" class=""></div>
                    <div id="u5910_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Ce formulaire de paiement est sécurisé par VisaSecur. Vous êtes en sécurité.</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Text Field) -->
                  <div id="u5911" class="ax_default text_field">
                    <input id="u5911_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5912" class="ax_default heading_1">
                    <div id="u5912_div" class=""></div>
                    <div id="u5912_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Informations sur la carte</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Text Field) -->
                  <div id="u5913" class="ax_default text_field">
                    <input id="u5913_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5914" class="ax_default heading_1">
                    <div id="u5914_div" class=""></div>
                    <div id="u5914_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Titulaire de la carte</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Shape) -->
                  <div id="u5915" class="ax_default icon">
                    <img id="u5915_img" class="img " src="./espace_gratuit_files/u1828.png">
                  </div>

                  <!-- Unnamed (Image) -->
                  <div id="u5916" class="ax_default image">
                    <img id="u5916_img" class="img " src="./espace_gratuit_files/u5916.png">
                  </div>
                </div>
              </div>
              <div id="u5906_state2" class="panel_state" data-label="Paypal" style="visibility: hidden; display: none;">
                <div id="u5906_state2_content" class="panel_state_content">

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5917" class="ax_default box_2">
                    <div id="u5917_div" class=""></div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5918" class="ax_default box_1">
                    <div id="u5918_div" class=""></div>
                  </div>

                  <!-- Bouton ajouter détails (Rectangle) -->
                  <div id="u5919" class="ax_default primary_button" data-label="Bouton ajouter détails" style="cursor: pointer;">
                    <div id="u5919_div" class="" tabindex="0"></div>
                    <div id="u5919_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;">Payer 79,00 €</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5920" class="ax_default label">
                    <div id="u5920_div" class=""></div>
                    <div id="u5920_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Connectez-vous à votre compte Paypal pour finaliser la commande</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Text Field) -->
                  <div id="u5921" class="ax_default text_field">
                    <input id="u5921_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5922" class="ax_default heading_1">
                    <div id="u5922_div" class=""></div>
                    <div id="u5922_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Mot de passe PayPal</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Text Field) -->
                  <div id="u5923" class="ax_default text_field">
                    <input id="u5923_input" type="text" value="" class="text_sketch" style="font-family: Raleway-Regular, Raleway; color: rgb(153, 153, 153);">
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5924" class="ax_default heading_1">
                    <div id="u5924_div" class=""></div>
                    <div id="u5924_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;">Login PayPal</span></p>
                    </div>
                  </div>

                  <!-- Unnamed (Shape) -->
                  <div id="u5925" class="ax_default icon">
                    <img id="u5925_img" class="img " src="./espace_gratuit_files/u1828.png">
                  </div>
                </div>
              </div>
              <div id="u5906_state3" class="panel_state" data-label="SMS" style="visibility: hidden; display: none;">
                <div id="u5906_state3_content" class="panel_state_content">

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5926" class="ax_default box_2">
                    <div id="u5926_div" class=""></div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5927" class="ax_default box_1">
                    <div id="u5927_div" class=""></div>
                  </div>

                  <!-- Unnamed (Rectangle) -->
                  <div id="u5928" class="ax_default heading_1">
                    <div id="u5928_div" class=""></div>
                    <div id="u5928_text" class="text ">
                      <p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;font-weight:400;">Envoyez le code</span></p><p><span style="font-family:&#39;Raleway-Bold&#39;, &#39;Raleway Bold&#39;, &#39;Raleway&#39;;font-weight:700;">AZE12345 au 33310</span></p><p><span style="font-family:&#39;Raleway-Regular&#39;, &#39;Raleway&#39;;font-weight:400;">pour finaliser le paiement de 79€</span></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  

<script src="./espace_gratuit_files/get"></script><iframe style="position:absolute;left:-999px;top:-999px;visibility:hidden" src="./espace_gratuit_files/saved_resource.html"></iframe></body></html>