<form id="form-newevent">
	<h1 id="title-newevent">New Event</h1>
	
	<div class="form-group" style="margin: auto;">
		<input type="file" id="selectImage" style="display: none;">
		<input type="button" class="btn btn-primary mb-2" value="Load a new photo" onclick="document.getElementById('selectImage').click();" />
		<button type="button" class="btn btn-primary mb-2">Remove selected</button>
	</div>
	<div class="form-group row">
		<label for="name-event" class="col-sm-2 col-form-label">Event name</label>
		<div class="col-sm-10">
			<input id="name-event" class="form-control" type="text" name="event-name" placeholder="Type event name">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-date" class="col-sm-2 col-form-label">Date/Hour</label>
		<div class="col-sm-10">
			<input id="event-date" class="form-control" type="date" name="event-date">
		</div>
		<label for="event-place" class="col-sm-2 col-form-label">Place</label>
		<div class="col-sm-10">
			<input id="event-place" class="form-control" type="text" name="event-place">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-price" class="col-sm-2 col-form-label">Price</label>
		<div class="col-sm-10">
			<input id="event-price" class="form-control" type="number" name="event-price">
		</div>
		<label for="event-maxtickets" class="col-sm-2 col-form-label">Max num. tickets</label>
		<div class="col-sm-10">
			<input id="event-maxtickets" class="form-control" type="number" name="event-maxtickets">
		</div>
	</div>
	<div class="form-group">
	    <label for="event-description">Description</label>
	    <textarea class="form-control" id="event-description" rows="5"></textarea>
  </div>
  <button type="button" class="btn btn-primary">Publish</button>
</form>
