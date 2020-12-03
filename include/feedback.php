<?php
if(isset($_POST['feedback'])){
  $userEmail = $_SESSION['username'];
  $clientResult = "SELECT * FROM client WHERE clientEmail = '{$userEmail}' LIMIT 1";
  $clientResult = $database->query($clientResult);
  $clientResult = mysqli_fetch_array($clientResult);
  $clientId = $clientResult['clientId'];
  $_SESSION['clientFullName'] = $clientResult['clientFullName'];
  if(!empty($_POST['question1']) && !empty($_POST['answer1']) &&
    !empty($_POST['question2']) && !empty($_POST['answer2']) &&
    !empty($_POST['question3']) && !empty($_POST['answer3']) &&
    !empty($_POST['question4']) && !empty($_POST['answer4']) &&
    !empty($_POST['suggestion']) && !empty($_POST['customerFullName']) &&
    !empty($_POST['customerAddress']) && !empty($_POST['customerMobileNumber']) &&
    !empty($_POST['customerEmail'])){
      $question1 = $_POST['question1'];
      $answer1 = $_POST['answer1'];
      $question2 = $_POST['question2'];
      $answer2 = $_POST['answer2'];
      $question3 = $_POST['question3'];
      $answer3 = $_POST['answer3'];
      $question4 = $_POST['question4'];
      $answer4 = $_POST['answer4'];

      $suggestion = $database->escape_value(trim($_POST['suggestion']));
      $customerFullName = $database->escape_value(trim($_POST['customerFullName']));
      $customerAddress = $database->escape_value(trim($_POST['customerAddress']));
      $customerMobileNumber = $database->escape_value(trim($_POST['customerMobileNumber']));
      $customerEmail = $database->escape_value(trim($_POST['customerEmail']));

      $sql = "INSERT INTO
      feedbackcollections(
        clientId,
        question1,
        answer1,
        question2,
        answer2,
        question3,
        answer3,
        question4,
        answer4,
        suggestion,
        customerFullName,
        customerAddress,
        customerMobileNumber,
        customerEmail)
      VALUES(
        '{$clientId}',
        '{$question1}',
        '{$answer1}',
        '{$question2}',
        '{$answer2}',
        '{$question3}',
        '{$answer3}',
        '{$question4}',
        '{$answer4}',
        '$suggestion',
        '$customerFullName',
        '$customerAddress',
        '$customerMobileNumber',
        '$customerEmail')";

        if($database->query($sql)){
          $_SESSION['feedbackMsg'] = '<script>bootbox.alert({title:"Your feedback has been sent successfully!",message: "Thank you for your feedback!"});</script>';
        }else{
          $_SESSION['feedbackMsg'] = '<script>bootbox.alert({title:"Invalid feedback",message: "The fields are empty!"});</script>';
        }
    }else{
      $_SESSION['feedbackMsg'] = '<script>bootbox.alert({title:"Invalid feedback",message: "The fields are empty!"});</script>';
    }
}

 ?>
<div class="menus-container container-feedback">
  <div class="container">
    <div class="page-header subcontainer-feedback" id="feedback">
      <h3 class="text-default text-uppercase text-center">Feedback</h3>
      <p class="text-center">Please provide your feedback below</p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

        <?php
        $query = "SELECT * FROM clientfeedback";
        $result = $database->query($query);
        while($question = $database->fetch_array($result)){ ?>
        <div class="text-left">
          <p class="font-weight-bold">
            <i class="fas fa-hand-point-right"></i>
            <?php echo isset($question['question']) ? $question['question'] : 'How do you rate your overall experience?'; ?>
            <input type="hidden" name="question<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" value="<?php echo isset($question['question']) ? $question['question'] : 'How do you rate your overall experience?'; ?>"/>
          </p>
          <div class="form-row">
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="answerA<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" name="answer<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" value="<?php echo isset($question['optionA']) ? $question['optionA'] : 'Good'; ?>" class="custom-control-input">
              <label class="custom-control-label" for="answerA<?php echo isset($question['id']) ? $question['id'] : '1'; ?>"><?php echo isset($question['optionA']) ? $question['optionA'] : 'Good'; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="answerB<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" name="answer<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" value="<?php echo isset($question['optionB']) ? $question['optionB'] : 'Very Good'; ?>"  class="custom-control-input">
              <label class="custom-control-label" for="answerB<?php echo isset($question['id']) ? $question['id'] : '1'; ?>"><?php echo isset($question['optionB']) ? $question['optionB'] : 'Very Good'; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="answerC<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" name="answer<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" value="<?php echo isset($question['optionC']) ? $question['optionC'] : 'Bad'; ?>"  class="custom-control-input">
              <label class="custom-control-label" for="answerC<?php echo isset($question['id']) ? $question['id'] : '1'; ?>"><?php echo isset($question['optionC']) ? $question['optionC'] : 'Bad'; ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="answerD<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" name="answer<?php echo isset($question['id']) ? $question['id'] : '1'; ?>" value="<?php echo isset($question['optionD']) ? $question['optionD'] : 'Very Bad'; ?>" class="custom-control-input">
              <label class="custom-control-label" for="answerD<?php echo isset($question['id']) ? $question['id'] : '1'; ?>"><?php echo isset($question['optionD']) ? $question['optionD'] : 'Very Bad'; ?></label>
            </div>
          </div>
          <hr class="stylish-hr-3" />
        </div>

      <?php } ?>

        <div class="text-left">
          <p for="txtAreaCustomerSuggestion" class="font-weight-bold">
            <i class="fas fa-hand-point-right"></i>
            Do you have any suggestion? If yes, we appreciate if you share it with us.
          </p>
          <div class="form-row">
            <textarea name="suggestion" placeholder="Write your suggestion here..." class="form-control"id="txtAreaCustomerSuggestion" rows="3"></textarea>
          </div>
          <hr class="stylish-hr-3" />
        </div>

        <div class="form-row text-left">
          <div class="col-md-3 mb-3">
            <label for="validationServer01">Your full name</label>
            <input type="text" name="customerFullName" class="form-control" id="validationServer01" placeholder="i.e. John Doe" required="required">
          </div>

          <div class="col-md-3 mb-3">
            <label for="validationServerUsername">Address</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend3"><i class="fas fa-street-view"></i></span>
              </div>
              <input type="text" name = "customerAddress" class="form-control" id="validationServerUsername" placeholder="i.e. Kabul" aria-describedby="inputGroupPrepend3" required="required">
            </div>
          </div>

          <div class="col-md-3 mb-3">
            <label for="validationServer02">Mobile Number</label>
            <input type="text" name="customerMobileNumber" class="form-control" id="validationServer02" placeholder="i.e. 0798203040" required="required">
          </div>
          <div class="col-md-3 mb-3">
            <label for="validationServerUsername">Username or email</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupPrepend3">@</span>
              </div>
              <input type="email" name="customerEmail" class="form-control" id="validationServerUsername" placeholder="john@gmail.com" aria-describedby="inputGroupPrepend3" required="required">
            </div>
          </div>
        </div>
        <button class="btn btn-success" name="feedback" type="submit">Submit feedback</button>
      </form>
    </div>
  </div>
</div>
