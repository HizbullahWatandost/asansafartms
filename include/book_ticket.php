<div class="menus-container container-book-ticket">
  <div class="container subcontainer-book-ticket">
    <div class="page-header menus-container" id="book_ticket">
      <h3 class="text-center text-white text-uppercase">Book A Ticket</h3>
      <hr class="stylish-hr-2" />
      <form name="product_search" method="get" action="index.php">
        <div class="form-row">
          <div class="form-group input-group col-md-6 mb-3">
             <div class="input-group-prepend">
               <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
             </div>
              <select class=" form-control select2bs4" name="srcPlace">
                <option selected="selected">Select the source place</option>
                <option>Kabul</option>
                <option>Mazar</option>
                <option>Laghman</option>
                 <option>Parwan</option>
                 <option>Takhar</option>
                 <option>Qandhar</option>
              </select>
          </div>
          <div class="form-group input-group col-md-6 mb-3">
             <div class="input-group-prepend">
               <span class="input-group-text"> <i class="fas fa-map-marker-alt"></i> </span>
             </div>
              <select class=" form-control select2bs4" name="srcPlace">
                <option selected="selected">Select the destination place</option>
                <option>Kabul</option>
                <option>Mazar</option>
                <option>Laghman</option>
                 <option>Parwan</option>
                 <option>Takhar</option>
                 <option>Qandhar</option>
              </select>
          </div>
        </div>
          <div class="form-row">
            <div class="col-md-6 mb-3" style="text-align: left;">
              <label for="dateLabel">Select Date</label>
              <div class="input-group" id="dateLabel">
                <input type="date" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2"><i class="fas fa-calendar-alt"></i></span>
                </div>
              </div>
            </div>
            <div class="col-md-6 mb-3" style="text-align: left;">
              <label for="vehicleTypeLable">Select Vehicle Type</label>
              <select class="form-control" id="vehicleTypeLable">
                <option>Bus 480</option>
                <option>Bus 404</option>
                <option>Bus 303</option>
                <option>Saraycha</option>
                <option>Crolla</option>
              </select>
            </div>
          </div>
          <button class="btn ticket-search-btn" type="submit">Search Vehicle</button>
        </form>
        <hr class="stylish-hr-2" />
      </div>
    </div>
  </div>
