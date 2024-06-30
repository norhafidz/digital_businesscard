
</div> <!-- end of container fluid -->


<!-- Modal Connect -->
<div class="modal fade" id="connectModal" tabindex="-1" aria-labelledby="connectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content animate-bottom">
      <div class="modal-header">
        <h6 class="mont" id="connectModalLabel">Exchange contact with <?php echo $preferred_name; ?></h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding: 30px;">
        <form method="POST" action="addcontact.php?id=<?php echo $user_idx; ?>" enctype="multipart/form-data">
            <!-- Upload image input-->
            <center>          
            <label>
                <i class="bi bi-camera btn btn-light rounded-pill" style="font-size: 39px;"></i>
                <input type="file" name="image" id="image" style="display:none" onchange="readURL(this);" class="form-control border-0">
            </label>
            </center>
           <div style="padding-top: 15px;"></div>
            <!-- Uploaded image area-->
            <div class="col-xl-3 col-lg-3 col-md-5 col-sm-5 mx-auto">
            <center><img id="imageResult" src="#" alt="" class="img-fluid rounded-circle shadow-sm mx-auto d-block" /></center>
            </div>
      <div style="padding-top: 15px;"></div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-person-plus"></i></span>
        <input type="text" class="form-control" placeholder="Name" aria-label="Name" id="fullname" name="fullname" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-envelope"></i></span>
        <input type="email" class="form-control" placeholder="Email" aria-label="Email" id="email" name="email" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-telephone-fill"></i></span>
        <input type="text" class="form-control" placeholder="Phone" aria-label="Phone" id="phone" name="phone" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-building"></i></span>
        <input type="text" class="form-control" placeholder="Company" aria-label="Company" id="company" name="company" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-briefcase"></i></span>
        <input type="text" class="form-control" placeholder="Designation" aria-label="Designation" id="designation" name="designation" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1"><i class="bi bi-chat-quote"></i></span>
        <input type="text" class="form-control" placeholder="Remarks. e.g: place of meeting" aria-label="Remarks" id="remarks" name="remarks" aria-describedby="basic-addon1">
        </div>

        <small>By clicking "Share", you agree to our <a href="#">Privacy Policy</a>, <a href="#">Terms of Use</a>, and our <a href="#">Disclaimer</a></small>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><strong>Close</strong></button>
        <button type="submit" name="submit" class="btn btn-primary"><strong>Share</strong></button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal why is memorable information needed? -->
<div class="modal fade" id="MemorableWhyModal" tabindex="-1" aria-labelledby="MemorableWhyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content animate-bottom">
      <div class="modal-header">
        <h6 class="mont" id="MemorableWhyModalLabel">What is memorable information?</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="padding: 30px;">
        Memorable information is an additional security feature used to help verify a customer's identity when accessing their account or editing the account contents (contacts, editing personal details, deleting contacts, changing account's password). This information typically consists of personal details that the customer chooses and provides when setting up their account, such as their mother's maiden name, their favorite color, or their first pet's name.<br/><br/> This information should be different from the password to prevent unauthorized access and reduce the risk of fraud. It's important to choose memorable information that is easy to remember but hard for others to guess.
      </div>
    </div>
  </div>
</div>
<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<!-- aos js and initialization -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>


<script>

/*  ==========================================
    SHOW UPLOADED IMAGE
* ========================================== */
function readURL(image) {
    if (image.files && image.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageResult')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(image.files[0]);
    }
}

$(function () {
    $('#image').on('change', function () {
        readURL(image);
    });
});

/*  ==========================================
    SHOW UPLOADED IMAGE NAME
* ========================================== */
var input = document.getElementById( 'upload' );
var infoArea = document.getElementById( 'upload-label' );

input.addEventListener( 'change', showFileName );
function showFileName( event ) {
  var input = event.srcElement;
  var fileName = input.files[0].name;
  infoArea.textContent = 'File name: ' + fileName;
}
</script>

<!-- initialization of search -->
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable a").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

  </body>
</html>