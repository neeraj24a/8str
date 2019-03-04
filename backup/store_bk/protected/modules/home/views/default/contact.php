<?php
$baseUrl = Yii::app()->theme->baseUrl;
?> 
<div class="clearfix"></div>
<!-- // BANNER AREA START // -->
<div class="aboutus_area no-bg">
  <div class="container">
    <div class="row">
      <div class="about_inner">        
        <div class="col-md-12">
        <h1 style="background:none;">CONTACT</h1>          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- // BANNER AREA END // -->
<div class="clearfix"></div>
<!-- // CONTACT US BOX AREA START // -->
<div class="contactus_box">
  <div class="container">
  <div class="contactus_inner">
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-4">
          <h1>CONTACT US</h1>
          <?php echo $contact_us_content->description;  ?>
        </div>
        <div class="col-md-8">
            <div class="contact_field">
              <label class="col-md-3">Name:</label>
              <input name="" type="text" placeholder="">
            </div>
             <div class="contact_field">
              <label class="col-md-3">Email:</label>
              <input name="" type="text" placeholder="" class="contact_bg"></div>
             <div class="contact_field">
              <label class="col-md-3">Contact No: </label>
              <input name="" type="text" placeholder="">
            </div>
            <div class="contact_field">
              <label class="col-md-3">Message:</label>
              <textarea name="" cols="" rows=""></textarea>
            </div>
             <div class="contact_field">
             <label class="col-md-3"></label>
              <input name="" type="submit" value="SUBMIT">
              <input name="" type="button" value="RESET" class="btnbg">
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- // CONTACT US BOX AREA END // -->
<div class="clearfix"></div>