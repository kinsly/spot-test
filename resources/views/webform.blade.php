<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Webform with IndexedDB</title>
  </head>
  <body>
    <div class="card text-center">
      <div class="card-header">
        Webform with IndexedDB
      </div>
      <div class="card-body">
        <div id="alert_error"></div>
        

        <div class="row">
          <div class="col-md-4">

            <form id="formData" onsubmit="event.preventDefault();">
              <div class="mb-3">
                <label for="username" class="form-label">User Name</label>
                <input type="text" class="form-control" id="username">
                
              </div>
  
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email">
              </div>
  
              <div class="mb-3">
                <label for="nic" class="form-label">NIC:</label>
                <input type="text" class="form-control" id="nic">
              </div>
  
              <button type="submit" class="btn btn-primary" onClick="submitForm()">Submit</button>
            </form>

          </div>
          <div class="col-md-6">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email</th>
                  <th scope="col">NIC</th>
                </tr>
              </thead>
              <tbody id="datatable_tbody"></tbody>
            </table>
          </div>
        </div>
      </div> {{-- End of card body --}}
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>


  <script>
    //indexedDB variable used to access inside functions
    let db;

    //Opening IndexedDB
    const dbRequest = indexedDB.open("db_webform", 1);

    //Setting structure of the database
    dbRequest.onupgradeneeded = function(event) {
      const db = event.target.result;
      const objectStore = db.createObjectStore("formData", { keyPath: "id", autoIncrement: true });
      objectStore.createIndex("name", "name", { unique: false });
      objectStore.createIndex("email", "email", { unique: true });
      objectStore.createIndex("nic", "nic", { unique: false });
    };

    //Handle error when opening indexedDB
    dbRequest.onerror = function(event) {
      console.error("Error opening IndexedDB:", event.target.errorCode);
    };

    //On success display indexedDB data on datatable
    dbRequest.onsuccess = function(event) {
      //Assign database instance to globally initiated variable at the beggining
      //So that db variable accessible inside functions
      db = event.target.result;
      displayData()
    };

    //Save form data to indexedDB onsubmit.
    function submitForm() {

      //Retreive data from form.
      const formData = {
        name: document.getElementById("username").value,
        email: document.getElementById("email").value,
        nic: document.getElementById("nic").value
      };

      //Check DB instance available
      if (!db) {
        console.error("IndexedDB not initialized properly.");
        return;
      }

      // Save data to IndexedDB
      const objectStore = db.transaction("formData", "readwrite").objectStore("formData");
      const request = objectStore.add(formData);

      //log on success
      request.onsuccess = function(event) { 
        console.log("Data added to IndexedDB");
        //Reset form
        document.getElementById("formData").reset();

        //Remove errors
        const contentDiv = document.getElementById("alert_error");
        contentDiv.innerHTML = '';

        //Show added entry on data table
        displayData()

      };

      //log on error
      request.onerror = function(event) { 
        const contentDiv = document.getElementById("alert_error");
        contentDiv.innerHTML += '<div class="alert alert-danger" role="alert">'+event.target.error+'</div>';
      };
    }

    /**
     *Display data on indexedDB on datatable.
     * Access globally for this document defined variable "db" to get required data
     * */
    function displayData(){
      objectStore = db.transaction("formData").objectStore("formData");

      // Get data table tbody
      const tableTbody = document.getElementById("datatable_tbody");
      tableTbody.innerHTML = '';//clearing tbody since we are looping through whole store.

      //Get all available data in indexedDB formdata store and add it to datatable.
      objectStore.openCursor().onsuccess = (event) => {
        const cursor = event.target.result;
        if (cursor) {
          tableTbody.innerHTML += `
                                  <tr>
                                    <th>${cursor.key}</th>
                                    <td>${cursor.value.name}</td>
                                    <td>${cursor.value.email}</td>
                                    <td>${cursor.value.nic}</td>
                                  </tr>`;
          cursor.continue();
        }
      };
    }

  </script>

</html>