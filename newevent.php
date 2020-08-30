<form id="form-newevent" action="php/addEvent.php" method="POST" enctype="multipart/form-data">
	<h1 id="title-newevent">New Event</h1>
	<svg id="emptyEventImage" viewBox="0 0 16 16" class="bi bi-card-image inputImage d-block" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
		<path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
		<path d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
		<path fill-rule="evenodd" d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
	</svg>
	<div id="carousel" class="carousel slide nonVisible" data-ride="carousel">
		<ol class="carousel-indicators">
		</ol>
		<div class="carousel-inner">
		</div>
		<a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<div class="form-group" style="margin: auto;">
		<input type="file" id="selectImage" style="display: none;" accept=".jpg, .jpeg, .png">
		<input type="button" class="btn btn-primary mb-2" value="Load a new photo" onclick="document.getElementById('selectImage').click();" />
		<button type="button" class="btn btn-primary mb-2" onclick="removeImage()">Remove selected</button>
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
			<input id="event-place" class="form-control" type="text" name="event-place" placeholder="Type the place">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-price" class="col-sm-2 col-form-label">Price per ticket</label>
		<div class="col-sm-10">
			<input id="event-price" class="form-control" type="number" name="event-price" placeholder="Type the price per ticket">
		</div>
		<label for="event-maxtickets" class="col-sm-2 col-form-label">Max num. tickets</label>
		<div class="col-sm-10">
			<input id="event-maxtickets" class="form-control" type="number" name="event-maxtickets" placeholder="Type the max number of tickets to sell">
		</div>
	</div>
	<div class="form-group row">
		<label for="event-category" class="col-sm-2 col-form-label">Category</label>
		<select class="form-control col-sm-10" id="event-category" name="event-category" >
			<?php
			require 'php/getCategories.php';
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="event-description">Description</label>
		<textarea class="form-control" id="event-description" name="event-description" rows="5" placeholder="Type the description of the event"></textarea>
	</div>
	<button id="event-publish" type="button" class="btn btn-primary" onclick="checkEvent()">Publish</button>
</form>

<script type="text/javascript">
	$("#form-newevent").submit(function(e){
		e.preventDefault();

		var items = $("#carousel .carousel-inner");
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		var form = $(this);
		var url = form.attr('action');
		var dataToSend = form.serializeArray();
		dataToSend.push({name: "imagesPresents", value: imagesPresents});

		var i;
		for(i = 0; i < imagesPresents; i++){
			var tmpImgSrc = $("#carousel-item-div-" + i + " img").attr('src');
			dataToSend.push({name: "Image" + i, value: tmpImgSrc});
		}
		console.log($.param(dataToSend));
		$.ajax({
			type: "POST",
			url: url,
			data: $.param(dataToSend),
			success: function(data){
				console.log(data);
				if(JSON.parse(data)["result"]){

				}
				else{
					Swal.fire({
						title: "Data error!",
						icon: "error"
					});
				}
			},
			error: function(data){
				Swal.fire({
					title: "Error!",
					icon: "error"
				});
			}
		});
	});

	function updateImageDisplay(event){
		var target = event.target, files = target.files;
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		var div = $("<div />"), img = $("<img />");
		div.addClass("carousel-item");
		div.attr('id', 'carousel-item-div-' + imagesPresents);
		img.addClass("inputImage d-block");
		img.prop("alt", imagesPresents + "° slide");
		
		

		$(".active").removeClass("active");

		$("#carousel .carousel-indicators").append('<li id="carousel-li-'+ imagesPresents + '" data-target="#carousel" data-slide-to="' + imagesPresents + '"></li>');
		$("#carousel-li-0").addClass("active");
		

		if (FileReader && files && files.length) {
			
			var fr = new FileReader();
			fr.onload = function (e) {
				img.prop("src", e.target.result);
			};
			fr.readAsDataURL(files[0]);
			div.append(img);
			$("#carousel .carousel-inner").append(div);
			$("#carousel-item-div-0").addClass("active");
		}
		$("#carousel").removeClass("nonVisible");
		$("#emptyEventImage").addClass("nonVisible");
		$("#emptyEventImage").removeClass("d-block");
	}

	function removeImage(){
		var indicators = $("#carousel .carousel-indicators");
		var items = $("#carousel .carousel-inner");
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		if(imagesPresents > 0){
			var indexActive = $(".carousel-indicators .active").attr("data-slide-to");
			var imgToRemove = $("#carousel-item-div-" + indexActive);

			var imgSrc = [];
			var i;
			for(i = 0; i < imagesPresents; i++){
				imgSrc.push($("#carousel-item-div-" + i + " img").attr('src'));
			}
			imgSrc.splice(indexActive, 1);

			indicators.empty();
			items.empty();

			if(imgSrc.length == 0){
				$("#carousel").addClass("nonVisible");
				$("#emptyEventImage").removeClass("nonVisible");
				$("#emptyEventImage").addClass("d-block");
			} else {
				for(i = 0; i < imgSrc.length; i++){
					indicators.append('<li id="carousel-li-'+ i + '" data-target="#carousel" data-slide-to="' + i + '"></li>');

					var div = $("<div />"), img = $("<img />");
					div.addClass("carousel-item");
					div.attr('id', 'carousel-item-div-' + i);
					img.addClass("inputImage d-block");
					img.prop("alt", i + "° slide");
					img.prop("src", imgSrc[i]);
					div.append(img);
					items.append(div);
				}
				$("#carousel-li-0").addClass("active");
				$("#carousel-item-div-0").addClass("active");
			}
			
		}
		
	}

	function checkEvent(){
		var name = $("#name-event").val();
		var date = $("#event-date").val();
		var place = $("#event-place").val();
		var price = $("#event-price").val();
		var maxtickets = $("#event-maxtickets").val();
		var category = $("#event-category").val();
		var description = $("#event-description").val();
		var imagesPresents = $("#carousel .carousel-indicators li").length;

		function verify(tmp, val){
			return typeof tmp != "undefined" && tmp !== val;
		}

		if(verify(name, "") && verify(date, "") && Date.parse(date) && verify(place, "") && verify(price, "") && verify(maxtickets, "") && maxtickets >= 0 && verify(category, "") && verify(description, "") && verify(imagesPresents, 0) && imagesPresents > 0){
			$("#form-newevent").submit();
		}
		else{
			Swal.fire({
				title: "Data error or missing!",
				icon: "error"
			});
		}
	}


	$(".inputImage").css("width", "30%");
	$("#form-newevent").css("width", "70%");

	document.getElementById("selectImage").addEventListener('change', updateImageDisplay);
</script>
