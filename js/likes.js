document.addEventListener("DOMContentLoaded", function(){

	var likebtns = document.querySelectorAll(".btn-like");
	for (var i = 0; i < likebtns.length; i++)
	{
		likebtns[i].addEventListener("click", function(){

			var request = new XMLHttpRequest();
			var fd = new FormData();
			var regex = /[0-9]+/g;
			var img_id = this.getAttribute("id").match(regex);	
			var user_id = this.getAttribute("data-postedby");	
			fd.append("img", img_id);
			fd.append("user_id", user_id);
			fd.append("type", "like");

			request.onreadystatechange = function(obj){
				if (this.readyState == 4 && this.status == 200)
				{
					var responseObj = JSON.parse(this.responseText);
					//console.log(responseObj);
					if(responseObj.status == "success")
					{
						var regex = /[0-9]+/g;
						var count = parseInt(obj.innerHTML.toString().match(regex));
						if (responseObj.action == "like")
						{
							count += 1;
						}
						else
						{
							count -= 1;
						}
						obj.innerHTML = "like "+ count;
						//console.log(parseInt(count + 1));
					}
				}
			}.bind(request, this);
			request.open("POST", "./likes.php", true);
			request.send(fd);
		});
	}

	var forms = document.querySelectorAll(".comment-form-submit");
	for (var i = 0; i < forms.length; i++)
	{
		forms[i].addEventListener("submit", function(e){
			e.preventDefault();
			//e.preventPropagation();

			var request = new XMLHttpRequest();
			var fd = new FormData(this);
			var btn = this.parentNode.querySelector("button");
			var regex = /[0-9]+/g;
			var img_id = btn.getAttribute("id").match(regex);
			fd.append("img", img_id);
			for (var pair of fd.entries()) {
				console.log(pair[0]+ ', ' + pair[1]); 
			}
			//console.log(btn);
			request.onreadystatechange = function(obj){
				if (this.readyState == 4 && this.status == 200)
				{
					var responseObj = JSON.parse(this.responseText);
					//console.log(responseObj);
					if(responseObj.status == "success")
					{
						obj.querySelector(".comment_section").innerHTML += responseObj.message;
						//console.log(parseInt(count + 1));
						//Clear out the input;
					}
				}
			}.bind(request, this.parentNode);
			request.open("POST", "./comment.php", true);
			request.send(fd);

		});
	}
});