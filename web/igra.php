<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="stil.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <title>The Number Game</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

  
  <script>
  
        let isRunning = false;
        let startTime;
        let intervalId;

// Declaration of the stopwatch
        function startStop() {
            if (isRunning) {
                clearInterval(intervalId);
            } else {
                startTime = Date.now() - (startTime ? startTime : 0);
                intervalId = setInterval(updateTime, 10);
            }
            isRunning = !isRunning;
        }

        function reset() {
            clearInterval(intervalId);
            isRunning = false;
            startTime = undefined;
            document.getElementById("stopwatch").textContent = "00:00:00";
        }

        function updateTime() {
            const currentTime = Date.now() - startTime;
            const minutes = Math.floor(currentTime / 60000);
            const seconds = Math.floor((currentTime % 60000) / 1000);
            const milliseconds = Math.floor((currentTime % 1000) / 10);

            const formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}:${String(milliseconds).padStart(2, '0')}`;
            document.getElementById("stopwatch").textContent = formattedTime;
        }

        function showText(){
          var unhide = document.getElementById("text");
          setTimeout(function() {
            unhide.style.display = "block";
          }, 1000);
        }

        function showTime(){
          $("#stopwatch").animate({
            width: '100vw' ,
            left: '+=38px',
            top: '+=250px',
            fontSize: '+=40px',
            
          }, 1000);
        }

    function getRandomInt(max) {
      return Math.floor(Math.random() * max);
    }

   
  var previous = 0;
    function set(){
      
      var el = document.getElementById("btn");
      el.remove();

      for(var i=1; i<11; i++){
        do{
          var x = getRandomInt(25);
          console.log(x);
          var box = document.getElementById("col"+ x);
        } while(box.childNodes.length != 0);
        var elem = document.createElement("img");
        elem.setAttribute("src", "num/"+i+".jpg");
        elem.setAttribute("id", "novi"+i);
        elem.setAttribute("onmouseover", "imgOnEnter(this.id)");
        elem.setAttribute("onmouseleave", "imgOnLeave(this.id)");
        elem.setAttribute("onclick", "imgOnClick(this.id)");
        
        document.getElementById("col"+ x).appendChild(elem);
      }
      reset();
      startStop();
    }

    function imgOnClick(id){

      var el = document.getElementById(id);

      var numb = el.getAttribute("src");

      var br = numb.match(/\d+/);
      
      if(br == previous + 1){
        previous++;
        el.remove()

        if(br == 20){
          previous = 0;
          startStop();
          showTime();
          showText();
          var score = document.getElementById('stopwatch').textContent;
          //console.log({ score: score });
          $.ajax({
              type: "POST",
              url: "scores.php", 
              data: { score: score }, 
              success: function(response) {
                  //alert("Highscore updated: " + score);
              }
          });
          
          var grid = document.getElementById('grid');
          grid.remove();
        }
      
        do{
          var x = getRandomInt(24);
          var box = document.getElementById("col"+ x);
        } while(box.childNodes.length != 0);

        br = +br + 10;
        if(br < 21){
          var elem = document.createElement("img");
          elem.setAttribute("src", "num/"+br+".jpg");
          elem.setAttribute("id", "novi"+br);
          elem.setAttribute("onmouseover", "imgOnEnter(this.id)");
          elem.setAttribute("onmouseleave", "imgOnLeave(this.id)");
          elem.setAttribute("onclick", "imgOnClick(this.id)");
          
          document.getElementById("col"+ x).appendChild(elem);

        }
      } 
    }
          
    function imgOnEnter(id){
      $("#" + id).css("height", "98%")
    }
    function imgOnLeave(id){
      $("#" + id).css("height", "100%")
    }

    function restartOnEnter(id){
      $("#" + 'restart').css("height", "45px")
    }
    function restartOnLeave(id){
      $("#" + 'restart').css("height", "48px")
    }

    function restartPage() {
    location.reload();
}


 // }
  </script>

</head>
<body>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="igra.php">The Number Game</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="instuctions.html">Instructions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="leaderboard.php">Leaderboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login/Register</a>
          </li>    
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="count" id="show">
    
    <button id="btn" onclick="set()">start!</button>
    
  </div>
  
  <img id="restart" src="restart.png" onmouseover="restartOnEnter()" onmouseleave="restartOnLeave()" onclick="restartPage()">
  
  <div id="stopwatch">00:00:00</div>
  <br>
  <div id="grid" class="contain">
    

    <div class="column" id="col0"></div>
    <div class="column" id="col1"></div>
    <div class="column" id="col2"></div>
    <div class="column" id="col3"></div>
    <div class="column" id="col4"></div>
  
    <div class="column" id="col5"></div>
    <div class="column" id="col6"></div>
    <div class="column" id="col7"></div>
    <div class="column" id="col8"></div>
    <div class="column" id="col9"></div>
    
    <div class="column" id="col10"></div>
    <div class="column" id="col11"></div>
    <div class="column" id="col12"></div>
    <div class="column" id="col13"></div>
    <div class="column" id="col14"></div>

    <div class="column" id="col15"></div>
    <div class="column" id="col16"></div>
    <div class="column" id="col17"></div>
    <div class="column" id="col18"></div>
    <div class="column" id="col19"></div>

    <div class="column" id="col20"></div>
    <div class="column" id="col21"></div>
    <div class="column" id="col22"></div>
    <div class="column" id="col23"></div>
    <div class="column" id="col24"></div>
  </div>
  <p id="text">YOUR TIME IS</p>

</body>
</html>

