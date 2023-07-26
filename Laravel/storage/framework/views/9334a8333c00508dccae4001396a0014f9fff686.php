<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

  <div class="container mt-5">
    <h1>Registration Form</h1>
    <form>
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" class="form-control" id="confirm-password" placeholder="Confirm your password" required>
      </div>
      <div class="form-group">
        <label for="country">Country:</label>
        <input type="text" class="form-control" id="country" placeholder="Enter your Country" >
      </div>
      <div class="form-group">
        <label for="state">State:</label>
        <input type="text" class="form-control" id="state" placeholder="Enter your state" >
      </div>
      <div class="form-group">
        <label for="address">Address:</label>
        <textarea class="form-control" id="address" placeholder="Enter your address" ></textarea>
      </div>
      <div class="form-group">
        <label>Gender:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="male" value="male" >
          <label class="form-check-label" for="male">
            Male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="female" value="female">
          <label class="form-check-label" for="female">
            Female
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="other" value="other">
          <label class="form-check-label" for="other">
            Other
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" class="form-control" id="dob" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div
<?php /**PATH C:\xampp\htdocs\Learning\resources\views/registration.blade.php ENDPATH**/ ?>