<html>
    <head>
        <title>NarColombia</title>
        <meta property="og:title" content="En cualquier parte de Guayaquil roban?" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://dotgoec.alwaysdata.net/narcolombia" />
        <meta property="og:image" content="https://dotgoec.alwaysdata.net/DotGoPix.png" />
        <meta property="og:description" content="Cartografías de robos urbanos en Guayaquil. 
Mirarnos en el espejo de NarColombia" />
        <meta property='og:image:width' content='400' />
        <meta property='og:image:height' content='400' />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <!-- Leaflet -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        <!-- Leaflet plugins -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/leaflet.markercluster.js" integrity="sha512-OFs3W4DIZ5ZkrDhBFtsCP6JXtMEDGmhl0QPlmWYBJay40TT1n3gt2Xuw8Pf/iezgW9CdabjkNChRqozl/YADmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.5.3/MarkerCluster.Default.css" integrity="sha512-6ZCLMiYwTeli2rVh3XAPxy3YoR5fVxGdH/pz+KMCzRY2M65Emgkw00Yqmhh8qLGeYQ3LbVZGdmOX9KUjSKr0TA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://yigityuce.github.io/Leaflet.Control.Custom/Leaflet.Control.Custom.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://masajid390.github.io/BeautifyMarker/leaflet-beautify-marker-icon.css">
        <script src="https://masajid390.github.io/BeautifyMarker/leaflet-beautify-marker-icon.js"></script>
        <link rel="stylesheet" href="https://maps.locationiq.com/v2/libs/leaflet-geocoder/1.9.6/leaflet-geocoder-locationiq.min.css">
        <script src="https://maps.locationiq.com/v2/libs/leaflet-geocoder/1.9.6/leaflet-geocoder-locationiq.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
        <script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
        <link href="https://unpkg.com/maplibre-gl@3.2.1/dist/maplibre-gl.css" rel='stylesheet' />
        <script src="https://unpkg.com/maplibre-gl@3.2.1/dist/maplibre-gl.js"></script>
        <script src="https://unpkg.com/@maplibre/maplibre-gl-leaflet@0.0.19/leaflet-maplibre-gl.js"></script>
        <script src="https://unpkg.com/leaflet.fullscreen@latest/Control.FullScreen.js"></script>
        <!-- Other js utilities -->
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js" crossorigin=""></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/nosleep/0.12.0/NoSleep.min.js" integrity="sha512-DSzvYfxJWRi3E6vfcGQfL5CqOlApxYrrdqRP3hRCnoiZ0oM6+ccYjbtdzQFUrAOI/ehKk0VKFuKs5GseGPkVjQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
        <style>
            :root {
                --gradient-percentage: 100%;
            }
            body {
                background-color: black;
                padding: 0;
                margin: 0;
                overflow: hidden;
            }
            html, body, #map {
                width: 100vw;
                height: 100%;
                z-index: 0;
            }
            a {
                color: cornflowerblue;
            }
            #addPointForm {
                width: 100%;
                text-align: center;
            }
            .pname {
                font-weight: bold;
                text-align: center;
            }
            .pnationality {
                text-align: center;
            }
            #info, #loading {
                position: absolute;
                top: 0;
                left: 0;
                padding: 0;
                margin: 0;
                width: 100vw;
                height: 100vh;
            }
            #info {
                background: radial-gradient(closest-corner, #000000cc var(--gradient-percentage), rgba(0,0,0,0) 100%);
                display: grid;
                font-family: system-ui;
                overflow: auto;
            }
            #infoText {
                background-color: #000000cc;
                margin: auto auto 0 auto;
                padding: 1em;
                vertical-align: middle;
                text-align: center;
                color: #fff;
                transform: scale(0.9);
            }
            #instructions > ol {
                /* list-style-position: inside; */
                text-align: left;
                margin: 0 auto;
                padding: 0 10%;
                max-width: max-content;
            }
            .asterisk {
                display: flex;
                margin: 0 auto;
                max-width: max-content;
                font-size: 0.83em;
            }
            #loading {
                background-color: #66666666;
                z-index: 100;
            }
            #loadgif {
                position: relative;
                -ms-transform: translate(-50%,-50%);
                transform: translate(-50%,-50%);
                top: 50%;
                left: 50%;
            }
            .button-state {
                font-size: 1.5em;
                text-align: center;
            }
            .qrcode {
                transform-origin: 10px calc(100% - 10px);
                /* transform: scale(0.2); */
                width: 100%;
                margin: 0;
                padding: 0;
                cursor: pointer;
                border-radius: 4px;
                border: 2px solid rgba(0,0,0,0.2);
            }
            #google_translate_element {
                background: #0000;
                transform: scale(0.75);
                text-align: center;
                margin: 0 auto auto auto;
            }
            [hidden] {
                display: none !important;
            }
        </style>
    </head>
    <body>
        <div id="map"></div>
        <div id="search-box"></div>
        <div id="result"></div>
        <div id="info" style="z-index: 10;">
            <div id="infoText">
                <hr />
                <h1 style="font-style: italic;">Mirarnos en el espejo de NarColombia</h1>
                <hr />
                <h2>En cualquier parte de Guayaquil roban?</h2>
                <h3>Cartograf&iacute;as de robos urbanos en Guayaquil</h3>
                <hr />
                <span id="description" hidden>
                </span>
                <span id="instructions">
                    <h4>Instrucciones de la muestra</h4>
                    <ol type="1">
                        <li>Busca un lugar de referencia del sitio donde te han robado (centro comercial, hospital, parque, etc)</li>
                        <li>Con el pin azul, a&ntilde;ade el punto con los datos que te solicitan (puedes arrastrar el pin azul o solo tocar o dar click en el mapa para moverlo)</li>
                        <li>Dale click a "A&ntilde;adir Punto" una vez hayas llenado los datos*</li>
                        <li>Despu&eacute;s de colocar el punto, puedes decidir si contar tu experiencia o no a nuestro <a href="https://t.me/dotgoec_bot" target="_blank">Bot de Telegram</a> o en el micr&oacute;fono en la muestra.</li>
                        <li>Puedes observar los otros puntos y los nombres de las dem&aacute;s personas</li>
                    </ol><br />
                    <span class="asterisk">*&nbsp;Puedes colocar tu nombre o pseu&oacute;nimo, o simplemente "An&oacute;nimo" si tienes miedo, preocupaci&oacute;n o no quieres usar tu nombre.</span><br />
                </span>
                <hr />
                <button id="infobtn" onclick="infoToggle()">Ocultar</button>
                <hr />
            </div>
            <div id="google_translate_element"></div>
        </div>
        <div id="loading"><img id="loadgif" src='../DotGoLoadDark.gif' /></div>
        <script>
            var debugging = false, init = false;
            if ( location.search.search('debug') > 0 ) debugging = true;
            // Opera 8.0+
            var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            // Firefox 1.0+
            var isFirefox = typeof InstallTrigger !== 'undefined';
            // Safari 3.0+ "[object HTMLElementConstructor]" 
            var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
            // Internet Explorer 6-11
            var isIE = /*@cc_on!@*/false || !!document.documentMode;
            // Edge 20+
            var isEdge = !isIE && !!window.StyleMedia;
            // Chrome 1 - 71
            var isChrome = !!window.chrome && (!!window.chrome.webstore || !!window.chrome.runtime);
            // Blink engine detection
            var isBlink = (isChrome || isOpera) && !!window.CSS;
            var root = document.querySelector(':root');
            const noSleep = new NoSleep();
            var info = document.getElementById('info'), infoTriggered = false, infoClosing = false, infoOpening = false, infoScale = 1, infoPosition = { x: 0, y: 0 };
            var loading = document.getElementById('loading');
            const WS_ADDRESS = "wss://dotgoec.alwaysdata.net/ws";
            var socket = new WebSocket(WS_ADDRESS);
            const defaultLatLng = new L.LatLng(-2.192029, -79.880256), centeredLatLng = new L.LatLng(-2.1579002, -79.9088502), addPointBtn = "<form><input type=\"submit\" id=\"pointSubmit\" value=\"A&ntilde;adir Punto\" formaction=\"javascript:addPoint()\"/></form>";
            var map = L.map('map',{
                preferCanvas: true,
                worldCopyJump: true,
                center: centeredLatLng
            }).fitWorld();
            var scale = L.control.scale().addTo(map).setPosition('bottomright'), clickPopup = addPointBtn, addPointForm = document.createElement('form');
            map.zoomControl.setPosition('bottomright');
            var liveLatLng, livePos = L.circle(defaultLatLng, {
                color: '#333',
                fillColor: '#666',
                fillOpacity: 0.3,
                radius: 0
            }), livePosID;
            var liveUpdateID, liveUpdate;
            var clickMarker = L.marker(defaultLatLng).bindPopup(clickPopup).addTo(map).removeFrom(map);
            var points = [], pointsGroup = ( location.search.search('cluster') > 0 ? L.markerClusterGroup() : L.layerGroup() ), layerControl = L.control.layers().addTo(map);
            var geocoder = L.control.geocoder('pk.c2496aa6035c8e2af4d1722c1a87a9f2',{
                params: {
                    countrycodes: 'EC'
                },
                focus: true,
                markers: false,
                placeholder: "Busca tu punto de referencia...",
                expanded: true,
                panToPoint: true,
                fullWidth: false
            }).addTo(map);
            geocoder._reset.innerHTML = "<b>&#8676;</b>";
            var infoMapBtn = L.easyButton('&#9776;',(b,m) => {
                if ( debugging ) console.log(b,m);
                infoToggle();
            }).addTo(map).setPosition('topleft');
            var resetViewBtn = L.easyButton('<b>&#8634;&nbsp;</b>',(b,m) => {
                if ( debugging ) console.log(b,m);
                map.flyTo( ( livePos.getRadius() > 0 ) ? liveLatLng : centeredLatLng, 12);
            }).addTo(map).setPosition('topleft');
            const pinIcon = ( 
                ( location.search.search('pinimg') > 0 ) ?
                L.icon({
                    iconUrl: 'google-maps-icon-png-23.png',
                    iconSize: [26, 34],
                    iconAnchor: [13, 34],
                    popupAnchor: [0, -30],
                    shadowUrl: 'google-maps-icon-png-23_shadow.png',
                    shadowSize: [26, 34],
                    shadowAnchor: [13, 34]
                })
                : L.BeautifyIcon.icon({
                    icon: 'info',
                    iconShape: 'marker',
                    iconSize: [25, 25],
                    backgroundColor: '#333c',
                    borderColor: '#333',
                    textColor: '#fff',
                    innerIconStyle: 'font-size:1.25em;margin:0.25em;'
                })
            );
            var customControl = L.control.custom({
                position: 'bottomleft',
                content : 'Comparte tu experiencia <a href="https://t.me/dotgoec_bot" target="_blank" title="Bot de Telegram" >aqu&iacute;</a>:<br><a href="https://t.me/narcolombia_gye2023" target="_blank" title="Canal de Telegram" ><img class="qrcode" src="telegram_qrcode.jpeg"></a>',
                // classes : 'qrcode',
                style   :
                {
                    margin: '10px',
                    padding: '0',
                    cursor: 'pointer',
                    width: '20%'
                },
                // datas   :
                // {
                    // 'foo': 'bar',
                // },
                // events:
                // {
                    // click: function(data)
                    // {
                        // console.log('wrapper div element clicked');
                        // console.log(data);
                    // },
                    // dblclick: function(data)
                    // {
                        // console.log('wrapper div element dblclicked');
                        // console.log(data);
                    // },
                    // contextmenu: function(data)
                    // {
                        // console.log('wrapper div element contextmenu');
                        // console.log(data);
                    // },
                // }
            });
		
            // create fullscreen control
            var fsControl = L.control.fullscreen({
                position:'bottomright',
                content: '<b>&#x26F6;</b>',
                fullscreenElement: map._container
            });
            // add fullscreen control to the map
            map.addControl(fsControl);
            // events are fired when entering or exiting fullscreen.
            map.on('enterFullscreen', function(e){
                if ( debugging ) console.log('entered fullscreen', e);
                infoMapBtn.removeFrom(map);
            });

            map.on('exitFullscreen', function(e){
                if ( debugging ) console.log('exited fullscreen', e);
                infoMapBtn.addTo(map);
            });
            const onMessage = (event) => {
                if ( debugging ) console.log("MSG:\n",event);
                let msg;
                try{
                    msg = JSON.parse(event.data);
                } catch(err) {
                    msg = [event.data];
                }
                if (debugging) console.log("NEW MESSAGE:\n",msg);
                switch (msg[0]) {
                    case "points":
                        points = [];
                        pointsGroup.clearLayers();
                        for ( i = 0; i < msg[1].length; i++ ) {
                            const p = msg[1][i].split(',');
                            if (debugging) console.log(p);
                            if ( p.length === 5 ) {
                                if ( !isNaN(p[1]) && !isNaN(p[2]) ) {
                                    const pi = points.push(L.marker([p[1],p[2]],{icon: pinIcon}).bindPopup(`<form onsubmit=\"return false\"><button class=\"pbutton\" onclick=\"javascript:map.flyTo(new L.LatLng(${p[1]},${p[2]}), 18)\" formaction=\"\"><span class=\"pname\">${p[0]}</span><br /><span class=\"pnationality\">${p[3]}</span></button>${ p[4] != ' ' ? '' : '' }</form>`)) - 1;
                                    pointsGroup.addLayer(points[pi]);
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            };
            
            const onOpen = (e) => {
                if (debugging) console.log("CONNECTED\n",e);
                if ( !init ) {
                    cookieStore.getAll().then((res)=>{
                        // "use strict";
                        if ( debugging ) console.log('COOKIES:\n',res);
                        
                        let cookies = {};
                        for ( let r of res ) {
                            if ( r.name.search("ID") > -1 ) socket.id = r.value;
                            else cookies[r.name] = r.value;
                        }
                    
                        esriWorldImageryLayers = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
                            minZoom: 2,
                            maxZoom: 18
                        });
                        
                        osmLayers = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            minZoom: 2,
                            maxZoom: 19
                        }).addTo(map);
                        /*
                        mapTilesLayers = L.tileLayer('https://maptiles.p.rapidapi.com/es/map/v1/{z}/{x}/{y}.png?rapidapi-key={apikey}', {
                            attribution: '&copy; <a href="http://www.maptilesapi.com/">MapTiles API</a>, &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                            apikey: cookies['mapTilesKey'],
                            minZoom: 2,
                            maxZoom: 20
                        });
                        */
                        stadiaOutdoorsLayers = L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
                            attribution: '&copy; <a href="https://stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/about" target="_blank">OpenStreetMap</a> contributors',
                            minZoom: 2,
                            maxZoom: 20,
                        });
                        
                        jawgStreetsLayers = L.tileLayer('https://tile.jawg.io/1fc15640-0c52-4fc8-9652-442422f37293/{z}/{x}/{y}{r}.png?access-token={accessToken}', {
                            attribution: '<a href=\"https://www.jawg.io\" target=\"_blank\">&copy; Jawg</a> - <a href=\"https://www.openstreetmap.org\" target=\"_blank\">&copy; OpenStreetMap</a>&nbsp;contributors',
                            accessToken: cookies['jawgKey'],
                            minZoom: 2,
                            maxZoom: 22
                        });
                        
                        mapTilerStreetsLayers = L.maplibreGL({
                            style: `https://api.maptiler.com/maps/streets-v2/style.json?key=${cookies['mapTilerKey']}`,
                            attribution: '<a href=\"https://maptiler.com/\" target=\"_blank\">&copy; MapTiler</a>'
                        });
                        
                        stadiaAlidadeSatelliteLayers = L.maplibreGL({
                            style: `https://tiles.stadiamaps.com/styles/alidade_satellite.json?api_key=${cookies['stadiaKey']}`,
                            attribution: '&copy; CNES, Distribution Airbus DS, &copy; Airbus DS, &copy; PlanetObserver (Contains Copernicus Data)'
                        });
                        
                        mapTilerSatelliteLayers = L.maplibreGL({
                            style: `https://api.maptiler.com/maps/satellite/style.json?key=${cookies['mapTilerKey']}`,
                            attribution: '<a href=\"https://maptiler.com/\" target=\"_blank\">&copy; MapTiler</a>'
                        });
                    
                        layerControl.addBaseLayer(esriWorldImageryLayers, "ESRI World Imagery");
                        layerControl.addBaseLayer(osmLayers, "Open Street Map");
                        // layerControl.addBaseLayer(mapTilesLayers, "Map Tiles API");
                        layerControl.addBaseLayer(stadiaOutdoorsLayers, "Stadia Outdoors");
                        layerControl.addBaseLayer(jawgStreetsLayers, "Jawg Streets");
                        layerControl.addBaseLayer(mapTilerStreetsLayers, "MapTiler Streets");
                        layerControl.addBaseLayer(stadiaAlidadeSatelliteLayers, "Stadia Alidade Satellite");
                        layerControl.addBaseLayer(mapTilerSatelliteLayers, "MapTiler Satellite");
                        
                        init = true;
                    });
                } 
                loading.hidden = true;
            };
            
            const onClose = (e) => {
                if (debugging) console.log("DISCONNECTED\n",e);
                loading.hidden = false;
            };
            
            function addLayers(live = false) {
                // layerControl.addOverlay(customControl, "C&oacute;digo QR");
                customControl.addTo(map);
                if ( live ) {
                    layerControl.addOverlay(livePos, "Tu posici&oacute;n actual");
                }
                layerControl.addOverlay(pointsGroup, "Puntos de usuarios");
                pointsGroup.addTo(map);
                layerControl.addOverlay(clickMarker, "Nuevo punto");
                clickMarker.addTo(map).dragging.enable();
                // layerControl.expand();
                geocoder.on('select', (e) => {
                  if ( debugging ) console.log(e);
                  map.flyTo(e.latlng, 18);
                  clickMarker.setLatLng(e.latlng);
                });
            }
            
            function toggleInfo() {
                if ( infoClosing ) info.hidden = true;
                // info.style['z-index'] = info.style['z-index'] * -1;
                // if ( info.hidden ) noSleep.enable();
                if ( livePosID === undefined ) {
                    noSleep.enable();
                    loading.hidden = false;
                    livePosID = navigator.geolocation.watchPosition(geoOk,geoErr);
                }
            }
            
            function infoToggle() {
                // if ( livePosID === undefined ) fsControl.toggleFullScreen();
                info.hidden = false;
                infoTriggered = true;
                if ( infoScale >= 1 ) infoClosing = true;
                if ( infoScale <= 0 ) infoOpening = true;
            }
            
            const geoOk = (pos) => {
                console.log("Live Location APPROVED:\n",pos);
                if ( liveLatLng === undefined ) {
                    loading.hidden = false;
                    liveLatLng = new L.LatLng(pos.coords.latitude, pos.coords.longitude);
                    livePos.setLatLng(liveLatLng);
                    livePos.addEventListener('click',(e)=>{
                        if (debugging) console.log("LIVE CLICK:\n",e);
                        map.flyTo(liveLatLng, 18);
                    });
                    clickMarker.setLatLng(liveLatLng);
                    addLayers(true);
                    setTimeout(()=>{
                        map.setView(centeredLatLng, 12);
                        loading.hidden = true;
                        livePos.addTo(map);
                    },500);
                } else {
                    liveLatLng.lat = pos.coords.latitude;
                    liveLatLng.lng = pos.coords.longitude;
                }
                livePos.setRadius(pos.coords.accuracy);
            };
            const geoErr = (err) => {
                console.error("Live Location DENIED:\n", err);
                if ( liveLatLng === undefined ) {
                    loading.hidden = false;
                    setTimeout(()=>{
                        map.setView(defaultLatLng, 12);
                        loading.hidden = true;
                    },500);
                    addLayers(false);
                }
            };
            
            function sendForm() {
                loading.hidden = false;
                try {
                    socket.send(JSON.stringify(["addPoint",`${document.getElementById("pointName").value},${clickMarker.getLatLng().lat},${clickMarker.getLatLng().lng},${document.getElementById("pointNationality").value},${" "}\n`]));
                    addPointForm.innerHTML = pointForm;
                    clickPopup = addPointBtn;
                    clickMarker.closePopup();
                    clickMarker.setPopupContent(clickPopup);
                    loading.hidden = true;
                    if ( liveLatLng === undefined ) clickMarker.setLatLng(defaultLatLng);
                    else clickMarker.setLatLng(liveLatLng);
                } catch(err) {
                    if ( debugging ) console.error(err);
                    setTimeout(sendForm,1000);
                }
            }
            
            function addPoint() {
                if (debugging) console.log("Punto");
                clickPopup = addPointForm;
                clickMarker.setPopupContent(addPointForm);
            }
            
            function onMapClick(e) {
                if (debugging) console.log("MAP CLICK:\n",e);
                clickMarker.setLatLng(e.latlng);
                if ( clickMarker.dragging != undefined ) {
                    clickMarker.setPopupContent(clickPopup).openPopup().dragging.enable();
                }
            }
            
            let esriWorldImageryLayers, osmLayers, mapTilesLayers, stadiaOutdoorsLayers, jawgStreetsLayers, mapTilerStreetsLayers, stadiaAlidadeSatelliteLayers, mapTilerSatelliteLayers;
            
            addPointForm.id = "addPointForm";
            addPointForm.action = '';
            const pointForm = `
                <label for=\"name\">Nombre: </label><br />
                <input type=\"text\" name=\"Name\" id=\"pointName\" placeholder=\"Nombre o An&oacute;nimo\" required /><br />
                <label for=\"nationality\">Nacionalidad: </label><br />
                <input type=\"text\" name=\"Nationality\" id=\"pointNationality\" placeholder=\"Ciudad o pa&iacute;s\" required /><br />
                <input type=\"submit\" id=\"pointSubmit\" value=\"A&ntilde;adir Punto\" formaction=\"javascript:sendForm()\"/>`
            addPointForm.innerHTML = pointForm;            
            socket.addEventListener('message', onMessage);
            socket.addEventListener('open', onOpen);
            socket.addEventListener('close', onClose);
            
            liveUpdate = (f) => {
                if ( liveLatLng != undefined ) livePos.setLatLng(liveLatLng);
                if ( socket.readyState === 3 ) {
                    if (debugging) console.log("DISCONNECTED.\nRELOADING...");
                    socket = new WebSocket(WS_ADDRESS);
                    socket.addEventListener('message', onMessage);
                    socket.addEventListener('open', onOpen);
                    socket.addEventListener('close', onClose);
                    socket.addEventListener('error', (err) => {
                        console.error('Socket encountered error: ', err.message, 'Closing socket');
                        socket.close();
                    });
                }
                if ( infoTriggered ) {
                    info.style['transform-origin'] = `${infoMapBtn.getContainer().getBoundingClientRect().x + ( infoMapBtn.getContainer().clientWidth / 2 )}px ${infoMapBtn.getContainer().getBoundingClientRect().y + ( infoMapBtn.getContainer().clientHeight / 2 )}px`;
                    if ( debugging ) console.log(infoScale);
                    if ( infoClosing ) info.style['transform'] = `scale(${ infoScale -= 0.05 })`;
                    if ( infoOpening ) info.style['transform'] = `scale(${ infoScale += 0.05 })`;
                    if ( infoClosing || infoOpening ) {
                        info.style['opacity'] = infoScale;
                        root.style.setProperty('--gradient-percentage', `${ infoScale.toFixed(2) * 100 }%`);
                    }
                    if ( infoOpening && infoScale >= 1 ) {
                        toggleInfo();
                        infoOpening = false;
                        infoTriggered = false;
                    }
                    if ( infoClosing && infoScale <= 0 ) {
                        toggleInfo();
                        infoClosing = false;
                        infoTriggered = false;
                    }
                }
                liveUpdateID = requestAnimationFrame(liveUpdate);
            };
            if ( !isFirefox ) {
                liveUpdateID = requestAnimationFrame(liveUpdate);
                map.on('click', onMapClick);
            } else {
                alert("Lo sentimos, por ahora la p\u00E1gina web no funciona correctamente en este navegador a\u00FAn, use otro navegador.\nRedirigiendo...");
                location.href='https://dotgoec.alwaysdata.net/';
            }
            function googleTranslateElementInit() {
                new google.translate.TranslateElement({
                    pageLanguage: 'es', 
                    // layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                }, 'google_translate_element');
            }
        </script>
    </body>
</html>
