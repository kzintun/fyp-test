/*function checkVisibleBar() { 
	var $element = document.getElementById('userSearchInput');
	if($('searchBar').is(':appeared') == false) {
	
		alert('disappeared');
	
	}
}

$(document).ready(function() {
	checkVisibleBar();
	setInterval(checkVisibleBar(), 10000);
});


$(document).ready(function() {
	checkVisibleBar();
});

function checkVisibleBar() {
  var $appeared = $('#searchBar');
  console.log($appeared);

  var $disappeared = $('#disappeared');
  console.log($disappeared );

  $('section searchBar').appear();
  $('#force').on('click', function() {
    $.force_appear();
  });

  $(document.body).on('appear', 'section searchBar', function(e, $affected) {
    // this code is executed for each appeared element
    $appeared.empty();
    $affected.each(function() {
      $appeared.append(this.innerHTML+"\n");
    })
    console.log($appeared);
  });

  $(document.body).on('disappear', 'section searchBar', function(e, $affected) {
    // this code is executed for each disappeared element
    $disappeared.empty();
    $affected.each(function() {
      $disappeared.append(this.innerHTML+"\n");
    })
    console.log($disappeared);

  });
};*/