<!-- These parts of our JavaScript API should be implemented on ALL website pages -->

<!-- Header code. Loads the scarab-v2.js and identifies the merchant account (here the emarsys demo merchant 1A65B5CB868AFF1E). Replace it with your own Merchant ID before hitting 'Run' -->
<script>
var ScarabQueue = ScarabQueue || [];
(function(subdomain, id) {
  if (document.getElementById(id)) return;
  var js = document.createElement('script'); js.id = id;
  js.src = subdomain + '.scarabresearch.com/js/#MERCHANT_ID#/scarab-v2.js';
  var fs = document.getElementsByTagName('script')[0];
  fs.parentNode.insertBefore(js, fs);
})('https:' == document.location.protocol ? 'https://recommender' : 'http://cdn', 'scarab-js-api');

// Passing on visitor's cart contents to feed cart abandonment campaigns
ScarabQueue.push(['cart', [
	{% if cart.item_count == 1 %}
	  	{% for item in cart.items %}
	  		{item: {{item.id}}, price: {{item.price}}, quantity: {{item.quantity}}}
		{% endfor %}
	{% else %}
		{% for item in cart.items %}
	  		{item: {{item.id}}, price: {{item.price}}, quantity: {{item.quantity}}},
		{% endfor %}
	{% endif %}
]]);


// Passing on item ID to report product view. Item ID should match the value listed in the Product Catalog
{% if template.name == 'product' %}
ScarabQueue.push(['view', {{ product.id }} ]);
{% endif %}
// Passing on the category path being visited. Must match the 'category' values listed in the Product Catalog
{% if template.name == 'collection' %}
ScarabQueue.push(['category', `{{ collection.title }}` ]);
{% endif %}

// Firing the ScarabQueue. Should be the last call on the page, called only once.
ScarabQueue.push(['go']);

// You can easily test how this works. Just replace the demo Merchant ID with your own.
// Log into your Predict Dashboard, click LIVE EVENTS, and on the event screen select 'my visit' from the dropdown. 
// Hit Run in JSFiddle. Refresh Live Events and you should see these event reported with the above values.
</script>
