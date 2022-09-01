$(document).ready(function () {

  loadresizemenu();

  $(window).resize(function(){

    loadresizemenu();

 });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
// Group Labels
var options = {
    chart: {
      type: 'bar',
      height: 'auto'
    },
    series: [{
      name: 'Client',
      data: [200,400,600,800,1000,1200,1400,1600,1800,2000]
    }],
    xaxis: {

      categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
    }
  }

  var chart = new ApexCharts(document.querySelector("#chart"), options);

  chart.render();

  // Bar Chart

  var options = {
    series: [{
    data: [44, 55, 41, 64, 22, 43, 21]
  }, {
    data: [53, 32, 33, 52, 13, 44, 32]
  }],
    chart: {
    type: 'bar',
    height: 380
  },
  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        position: 'top',
      },
    }
  },

  fill: {
colors: ['#17D165', '#F62D18']
},
  dataLabels: {
    enabled: true,
    offsetX: -6,
    style: {
      fontSize: '12px',
      colors: ['#fff']
    }
  },
  stroke: {
    show: true,
    width: 1,
    colors: ['#fff']
  },
  tooltip: {
    shared: true,
    intersect: false
  },
  xaxis: {
    categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
  },
  legend: {
    show: true,
    labels: {
      colors: ['#17D165', '#F62D18'],
  },
  markers: {
    fillColors: ['#17D165', '#F62D18'],

},
tooltip:
{
  style: {
    Colors: ['#17D165', '#F62D18'],

  },
},
},

  };

  var chart = new ApexCharts(document.querySelector("#chart2"), options);
  chart.render();

//   Donut Chart

// Donut Chart
var options = {
    chart: {
      width: 450,

      type: "donut"
    },
    dataLabels: {
      enabled: false
    },
          legend: {
              show: true,
              position: "bottom",
              align: "middle",
              borderWidth: 9,
              fontSize: "14px"

          },
    series: [20,40,20,30,30,20],
    labels: ['Proposal', 'Estimation','Invoices','Payments','Credit','Expenses'],
    fill: {
colors: ['#FF9E01', '#F8FF01','#B0DE09','#04D215','#0D8ECF','#FF0F00']
},

markers: {
fillColors: ['#ff0f00', '#352c7b'],

},

  };

  var chart = new ApexCharts(document.querySelector("#chart3"), options);

  chart.render();

function random() {
return Math.floor(Math.random() * (100 - 1 + 1)) + 1;
}

// Donut Chart
var options = {
    chart: {
      width: 140,
      type: "donut"
    },
    dataLabels: {
      enabled: false
    },
           legend: {
               show: false

           },
    series: [65,35],
    // labels: ['Proposal'],
    fill: {
    colors: ['#61CEB6','#CECECE']
    },

markers: {
fillColors: ['#61CEB6','#CECECE'],

},

  };

  var chart = new ApexCharts(document.querySelector("#chart4"), options);

  chart.render();

function random() {
return Math.floor(Math.random() * (100 - 1 + 1)) + 1;
}

// Data Table
$(document).ready(function () {
  $('#example').DataTable({
    // "dom": 'rt<"bottom"flip>',
  });
  $('select').selectpicker();
});

// Upload Image
function readURL(input) {
  if (input.files && input.files[0]) {

    var reader = new FileReader();

    reader.onload = function(e) {
      $('.image-upload-wrap').hide();

      $('.file-upload-image').attr('src', e.target.result);
      $('.file-upload-content').show();

    //   $('.image-title').html(input.files[0].name);
    };

    reader.readAsDataURL(input.files[0]);

  } else {
    removeUpload();
  }
}

function removeUpload()
{
  $('.file-upload-input').replaceWith($('.file-upload-input').clone());
  $('.file-upload-content').hide();
  $('.image-upload-wrap').show();
}





$('.image-upload-wrap').bind('dragover', function ()
{
		$('.image-upload-wrap').addClass('image-dropping');
});

$('.image-upload-wrap').bind('dragleave', function () {
	$('.image-upload-wrap').removeClass('image-dropping');
});

// Select Item
// $('#item').hide();
function selectItem(){
  $('#item').show();
}


// Product Image

const imgContElm = document.querySelector('.img-container');
const imgElm = document.querySelector('.img-container img');
const listProductsElm = document.querySelector('.list-products');

// Precentage Of The Zoom:
const ZOOM = 300;

// Event Mouse Enter:
imgContElm.addEventListener('mouseenter', function () {

  imgElm.style.width = ZOOM + '%';

});

// Event Mouse Leave:
imgContElm.addEventListener('mouseleave', function () {

  imgElm.style.width = '100%';
  imgElm.style.top = '0';
  imgElm.style.left = '0';

});

// Event Mouse Move:
// Change position of the big image, depends on the position of the cursor in the Container Of image.
imgContElm.addEventListener('mousemove', function (mouseEvent) {

  let obj = imgContElm;
  let obj_left = 0;
  let obj_top = 0;
  let xpos;
  let ypos;

  while (obj.offsetParent) {
    obj_left += obj.offsetLeft;
    obj_top += obj.offsetTop;
    obj = obj.offsetParent;
  }

  if (mouseEvent) {
    //FireFox
    xpos = mouseEvent.pageX;
    ypos = mouseEvent.pageY;
  } else {
    //IE
    xpos = window.event.x + document.body.scrollLeft - 2;
    ypos = window.event.y + document.body.scrollTop - 2;
  }

  xpos -= obj_left;
  ypos -= obj_top;

  const imgWidth = imgElm.clientWidth;
  const imgHeight = imgElm.clientHeight;

  imgElm.style.top = -(((imgHeight - this.clientHeight) * ypos) / this.clientHeight) + 'px';
  imgElm.style.left = -(((imgWidth - this.clientWidth) * xpos) / this.clientWidth) + 'px';

});

// Change The Current Image:
Array.from(listProductsElm.children).forEach((productElm, i, list) => {

  productElm.addEventListener('click', function () {
    const newSrc = productElm.querySelector('img').src;
    imgElm.src = newSrc;

    list.forEach(prod => prod.classList.remove('active'));
    productElm.classList.add('active');
  });

});

// Change Height Of The Image Container:
function changeHeight() {

  imgContElm.style.height = imgContElm.clientWidth + 'px';

}
changeHeight();

// Change Height:
window.addEventListener('resize', changeHeight);








function loadresizemenu()
{

 var currentwidth=$(window).width();
 var sidebar=$("#sidebar").attr("class");
 //
 // console.log(currentwidth);

 if(currentwidth <= 992)
 {

  $("#sidebar").attr("class", "");

 }
 else
 {

  $("#sidebar").attr("class", "");

 }


}

// CK Editor

ClassicEditor
                                .create( document.querySelector( '#editor' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );




