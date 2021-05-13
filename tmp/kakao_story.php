<!doctype HTML>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>API Demo: Post link to KakaoStory  - Kakao Javascript SDK</title>
    <script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
  </head>
  <body>
    <a id="kakao-login-btn"></a>

    <div>
      <p id="post-result"></p>
    </div>

    <script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init('ef69d90d05aa5fb6a72887cbb5a896a2');
    Kakao.Auth.createLoginButton({
      container: '#kakao-login-btn',
      success: function() {

        // 로그인 성공시, API를 호출합니다.
        Kakao.API.request( {
          url : '/v1/api/story/linkinfo',
          data : {
            url : 'http://njob.netfu.co.kr/alba/alba_detail.php?no=45'
          }
        }).then(function(res) {
          // 이전 API 호출이 성공한 경우 다음 API를 호출합니다.
          return Kakao.API.request( {
            url : '/v1/api/story/post/link',
            data : {
              link_info : res
            }
          });
        }).then(function(res) {
          return Kakao.API.request( {
            url : '/v1/api/story/mystory',
            data : { id : res.id }
          });
        }).then(function(res) {
          document.getElementById('post-result').innerHTML = JSON.stringify(res);
        }, function (err) {
          alert(JSON.stringify(err));
        });

      },
      fail: function(err) {
        alert(JSON.stringify(err))
      }
    });
    </script>
  </body>
</html>