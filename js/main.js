document.addEventListener('DOMContentLoaded', function () {

  console.log(document.querySelector('#myForm'));
  console.log("jestem form");


  document.querySelector('#myForm').addEventListener('submit', function (e) {
    e.preventDefault();

    // Your existing AJAX form submission code using vanilla JavaScript
    var xhr = new XMLHttpRequest();
    var formData = new FormData(this);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);

          if (response.success) {
            // Update content on success
            document.getElementById('result').innerHTML =
              'Email: ' + response.data.email + '<br>' +
              'Name: ' + response.data.name + '<br>' +
              'Message: ' + response.data.message + '<br>' +
              'Package: ' + response.data.package + '<br>' +
              'Message: ' + response.message;
          } else {
            // Display error message
            alert(response.message);
          }
        } else {
          // Handle HTTP error
          alert('An error occurred during form submission.');
        }
      }
    };

    xhr.open('POST', '../forms/contact.php', true);
    xhr.send(formData);
  });
});