@extends( 'base' )

@section( 'content' )


            <section class="cd-products-comparison-table">
                <header>
                   <h2>Compare Models</h2>
             
                   <div class="actions">
                      <a href="#0" class="reset">Reset</a>
                      <a href="#0" class="filter">Filter</a>
                   </div>
                </header>
             
                <div class="cd-products-table">
                   <div class="features">
                      <div class="top-info">Models</div>
                      <ul class="cd-features-list">
                         <li>Price</li>
                         <li>Customer Rating</li>
                         <li>Resolution</li>
                         <!-- other features here -->
                      </ul>
                   </div> <!-- .features -->
             
                   <div class="cd-products-wrapper">
                      <ul class="cd-products-columns">
                         <li class="product">
                            <div class="top-info">
                               <div class="check"></div>
                               <img src="../img/product.png" alt="product image">
                               <h3>Sumsung Series 6 J6300</h3>
                            </div> <!-- .top-info -->
             
                            <ul class="cd-features-list">
                               <li>$600</li>
                               <li class="rate"><span>5/5</span></li>
                               <li>1080p</li>
                               <!-- other values here -->
                            </ul>
                         </li> <!-- .product -->
             
                         <li class="product">
                            <!-- product content here -->
                         </li> <!-- .product -->
             
                         <!-- other products here -->
                      </ul> <!-- .cd-products-columns -->
                   </div> <!-- .cd-products-wrapper -->
             
                   <ul class="cd-table-navigation">
                      <li><a href="#0" class="prev inactive">Prev</a></li>
                      <li><a href="#0" class="next">Next</a></li>
                   </ul>
                </div> <!-- .cd-products-table -->
             </section> <!-- .cd-products-comparison-table -->
      


@endsection

@section('extraCSS')
<style>
    .cd-products-wrapper {
  overflow-x: auto;
  /* this fixes the buggy scrolling on webkit browsers - mobile devices only - when overflow property is applied */
  -webkit-overflow-scrolling: touch;
}

.cd-products-table .features {
  /* fixed left column - product properties list */
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  width: 120px;
}

.cd-products-columns {
  /* products list wrapper */
  width: 1200px; /* single column width * products number */
  margin-left: 120px; /* .features width */
}

@media only screen and (min-width: 1170px) {
  .cd-products-table.top-fixed .cd-products-columns > li {
    padding-top: 160px;
  }

  .cd-products-table.top-fixed .top-info {
    height: 160px;
    position: fixed;
    top: 0;
  }

  .cd-products-table.top-fixed .top-info h3 {
    transform: translateY(-116px);
  }
  
  .cd-products-table.top-fixed .top-info img {
    transform: translateY(-62px) scale(0.4);
  }

}
    </style>
@endsection

@section('extraJS')
<script>
    function productsTable( element ) {
   this.element = element;
   this.table = this.element.children('.cd-products-table');
   this.productsWrapper = this.table.children('.cd-products-wrapper');
   this.tableColumns = this.productsWrapper.children('.cd-products-columns');
   this.products = this.tableColumns.children('.product');
   //additional properties here
   // bind table events
   this.bindEvents();
}

productsTable.prototype.bindEvents = function() {
   var self = this;

   self.productsWrapper.on('scroll', function(){
      //detect scroll left inside products table
   });

   self.products.on('click', '.top-info', function(){
      //add/remove .selected class to products 
   });

   self.filterBtn.on('click', function(event){
      //filter products
   });
   //reset product selection
   self.resetBtn.on('click', function(event){
      //reset products visibility
   });

   this.navigation.on('click', 'a', function(event){
      //scroll inside products table - left/right arrows
   });
}

var comparisonTables = [];
$('.cd-products-comparison-table').each(function(){
   //create a productsTable object for each .cd-products-comparison-table
   comparisonTables.push(new productsTable($(this)));
});
</script>
@endsection