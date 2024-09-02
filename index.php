<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> 
    <link rel="stylesheet" href="style.css">
    <title>Register & Login</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #emailCheckMessage{
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-110%);
    font-size: 0.8em;
    color: red;
}
</style>

</head>
<body>
    <div class="container" id="signup" style="display:none;">
      <h1 class="form_title">회원가입</h1>
      <form method="post" action="register.php">
        <div class="input_group">
        <i class="bi bi-person" id="logregicon"></i>
           <input type="text" name="fName" id="fName" placeholder="First Name" required>
           <label for="fname">이름</label>
        </div>
        <div class="input_group">
        <i class="bi bi-person" id="logregicon"></i>
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">성</label>
        </div>

        <div class="input_group">
        <i class="bi bi-envelope" id="logregicon"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <label for="email">이메일</label>
            <span id="emailCheckMessage" style="color: red;"></span>
        </div>
        <div class="input_group">
        <i class="bi bi-key" id="logregicon"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">비밀번호</label>
        </div>
       <input type="submit" class="btn" value="회원가입" name="signUp" id="signUpBtn">
      </form>
      <p class="or">
      </p>
      <div class="icons">
      <i class="bi bi-google"></i>
      <i class="bi bi-facebook"></i>
      <i class="bi bi-github"></i>
      <i class="bi bi-twitter-x"></i>
      </div>
      <div class="links">
        <p>계정이 이미 있으신가요?</p>
        <button id="signInButton"> 로그인 </button>
      </div>
    </div>

    <script>
    $(document).ready(function() {
        $("#email").on("focusout", function() {
            var email = $("#email").val();

            if (email == '' || email.length == 0) {
            $("#emailCheckMessage").css("color", "red").text("필수 항목입니다");
            return false;
        }
            // Ajax request to check email
            $.ajax({
                url: 'check_email.php',
                type: 'POST',
                data: { email: email },
                dataType: 'json',
                success: function(response) {
                    if (response == false) {
                        $("#emailCheckMessage").css("color", "red").text("사용중인 이메일입니다");
                        $("#signUpBtn").prop('disabled', true); // Disable signup button
                    } else {
                        $("#emailCheckMessage").css("color", "green").text("사용 가능한 이메일입니다");
                        $("#signUpBtn").prop('disabled', false); // Enable signup button
                    }
                }
            });
        });
    });
    </script>

    <div class="container" id="signIn">
        <h1 class="form_title">로그인</h1>
        <form method="post" action="register.php" id="signInForm">
          <div class="input_group">
          <i class="bi bi-envelope" id="logregicon"></i>
              <input type="email" name="email" id="signInEmail" placeholder="Email" required>
              <label for="email">이메일</label>
              <span id="loginErrorMessage"></span>
          </div>
          <div class="input_group">
          <i class="bi bi-key" id="logregicon"></i>
              <input type="password" name="password" id="signInPassword" placeholder="Password" required>
              <label for="password">비밀번호</label>
          </div>
          <p class="recover">
            <a href="#">비밀번호 찾기</a>
          </p>
         <input type="submit" class="btn" value="로그인" name="signIn" id="signInBtn">
        </form>
        <p class="or">
        </p>
        <div class="icons">
        <i class="bi bi-google"></i>
      <i class="bi bi-facebook"></i>
      <i class="bi bi-github"></i>
      <i class="bi bi-twitter-x"></i>
        </div>
        <div class="links">
          <p>계정이 없으신가요?</p>
          <button id="signUpButton">회원가입</button>
        </div>
      </div>

      <script src="script.js"></script>

</body>
</html>