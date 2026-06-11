jQuery(document).ready(function () {


var lazyInit = (element, fn) => {
    
    var observer = new IntersectionObserver((entries) => {
        if (entries.some(({isIntersecting}) => isIntersecting)) {
            observer.disconnect();
            fn();
        }
    });

    observer.observe(element);
};  

function addslashes(str) {
	str = str.replace(/'/g, " ");
	return str;
}

var mapElement = document.querySelector("#mapid");
lazyInit(mapElement, () => {


        var organizations = JSON.parse($("#agencies-for-js").attr('data-agencies'));
		        
        var markers = [];
        var bounds = [];
        //loop on agencies to build markers and infoWindowContent
        $.each(organizations, function (key, organization) {
			
			
			//if no latlng, ask google api geocode
			if (organization['latitude'] == '' || organization['latitude'] == '-1.0'){
				console.log('go manually for geocode');
				var geoCodeSearchString = organization['name']+'+'+organization['address']+'+'+organization['zipcode']+'+'+organization['city'];
				$.ajax({
					url: 'https://maps.googleapis.com/maps/api/geocode/json?address='+geoCodeSearchString+'&key=AIzaSyBha_MiqfeGNnPHHLDdfYW5cnLdleIrfS4',
					type: 'GET',
					async: false,
					success: function (data)
					{
						try {
							console.log('success on geocoding');
							console.log(data);
							console.log(data['results'][0]['geometry']['location']);
							organization['latitude'] = data['results'][0]['geometry']['location']['lat'];
							organization['longitude'] = data['results'][0]['geometry']['location']['lng'];
						} catch {
							console.log('in catch');
							organization['latitude'] = false;
						}
					},
				error: function () {
				console.log('error on geocoding');
					}
				});
			};
			//check if manual geocode has worked, if not skip this marker
			if(organization['latitude'] == false){
				return;
			};			
			
            var marker = {};
            marker["name"] = organization['name'];
            marker["latitude"] = organization['latitude'];
            marker["longitude"] = organization['longitude'];
            marker["address"] = organization['address'];
            marker["zipcode"] = organization['zipcode'];
            marker["city"] = organization['city'];
            //marker["slug"] = organization['slug'];
            //marker["permalink"] = organization['permalink'];
            marker["number"] = organization['number'];
            markers.push(marker);

            var bound = [];
            bound[0] = organization['latitude'];
            bound[1] = organization['longitude'];
            bounds.push(bound);
        });

        var map = L.map('mapid').fitBounds(bounds, {padding: [30,30]});


        mapLink = '<a href="https://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 18,
            }).addTo(map);

		var LeafIcon = L.Icon.extend({
			options: {
				shadowUrl: '../img/marker-1-shadow.png',
				iconSize:     [44, 64],
				shadowSize:   [64, 64],
				iconAnchor:   [22, 63],
				shadowAnchor: [17, 63],
				popupAnchor:  [-3, -76]
			}
		});

		var pffIcon = new LeafIcon({iconUrl: '../img/marker-1.png'});

        var allMarkers =[];

        for (var i = 0; i < markers.length; i++) {
            marker = new L.marker([markers[i]['latitude'],markers[i]['longitude']],{icon: pffIcon},{bounceOnAdd: true })
                .bindPopup("<div class='info_content'>" + "<ul class='left-align light collapsible'>" + "\n" +
                        "<li><b>" + markers[i]['name'] + "</b></li>" + "\n" +
                        "<li>" + markers[i]['address'] + "</li>" + "\n" +
						"<li>" + markers[i]['zipcode']+ "</li>" + "\n" +
						"<li>" + "<a href='https://www.google.com/maps/dir/?api=1&destination=" + addslashes(markers[i]['address']) + "+" + addslashes(markers[i]['city']) + "' target='_blank'>Obtenir l'itinéraire</a></li>" + "\n" +
                        "</ul>"
                    +"</div>", {closeOnClick: false, autoClose: false})
                .addTo(map).openPopup();
                //allMarkers.push(marker);
            };

        jQuery('.list-agencies').hover(
            // mouse in
            function () {
            // first we need to know which <div class="marker"></div> we hovered
            var index = jQuery(this).attr('id');
            allMarkers[index].bounce({duration: 1500, height: 30, loop: 20});
            },
            // mouse out
            function () {
            // first we need to know which <div class="marker"></div> we hovered
            var index = jQuery(this).attr('id');
            allMarkers[index].stopBounce();
            }
        );
    });

});