<?php
  $email = "";
  $fname = "";
  $lname = "";
  $userid = 0;
  $closetid = 0;

  session_start();
  $email = $_SESSION["email"];

  require_once("db.php");
  $sql = "select fname, lname, userid, closetid from user where email='$email'";
  $result = $mydb->query($sql);

  $row = mysqli_fetch_array($result);
  if($row) {

    $fname = $row['fname'];
    $lname = $row['lname'];
    $userid = $row['userid'];
    $closetid = $row['closetid'];

    $_SESSION['fname'] = $fname;
    $_SESSION['lname'] = $lname;
    $_SESSION['userid'] = $userid;
    $_SESSION['closetid'] = $closetid;
  }

 ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clothes Doors</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="other_mamp.css"/>
  <script src="jquery-3.1.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>



<script>

    function createCloset(clothes){
      function clear(){
      var myNode = document.getElementById("contentArea");
      while (myNode.firstChild) {
      myNode.removeChild(myNode.firstChild);
      }
    }
    clear();

        var i = 1;
        var shirtcnt = 1;
        var pantcnt = 1;
        var shoecnt = 1;
        var acnt = 1;
        for(i=0;i<clothes.length;i++){
          var anode = document.createElement("div");

          anode.classList.add("col-xs-5", "col-sm-4", "col-md-3");

          var hnode = document.createElement("h3")
          var tnode = document.createTextNode("")
          switch(clothes[i]['type']){
              case "shirt":
              tnode.nodeValue= clothes[i]['type'] + ' ' + shirtcnt;
              shirtcnt++;
              break;
              case "pants":
                tnode.nodeValue= clothes[i]['type'] + ' ' + pantcnt;
                pantcnt++;
                break;
              case "shoes":
            tnode.nodeValue= clothes[i]['type'] + ' ' + shoecnt;
                shoecnt++;
                break;
              case "accessories":
            tnode.nodeValue= clothes[i]['type'] + ' ' + acnt;
                acnt++;
                break;
                  default:
                break;
        }
        hnode.appendChild(tnode);
        anode.appendChild(hnode);

        var imgNode = document.createElement("img");
        imgNode.classList.add("img-thumbnail");
        imgNode.id = "cat";
        imgNode.setAttribute("src",clothes[i]['image'] );
        anode.appendChild(imgNode);
      //  document.getElementById('contentArea').lastchild.innerHTML += "<img class='img-thumbnail' id='cat' src='" + clothes[i]['image'] +  "' />";
      //document.getElementById('contentArea').lastchild.innerHTML += "<br />";
        var bnode = document.createElement("div");


        bnode.classList.add("btn-group");


        var wear = document.createElement("button");
        wear.classList.add("btn", "btn-primary");
        wear.id ="btn" + clothes[i]['clothesid'];

        wear.setAttribute("onclick", "addWear(this.id)");
        wear.appendChild(document.createTextNode("wear"));

        bnode.appendChild(wear);
        anode.appendChild(bnode);
  //    document.getElementById('contentArea').lastchild.innerHTML += '<div class="btn-group">';
  //    document.getElementById('contentArea').lastchild.lastchild.innerHTML += '<button type="button" class="btn btn-primary">Edit</button>';
  //    document.getElementById('contentArea').lastchild.lastchild.innerHTML += '<button type="button" class="btn btn-primary">Wear</button>';
  //document.getElementById('contentArea').lastchild.lastchild.innerHTML +='<button type="button" class="btn btn-primary">Delete</button>';

  document.getElementById("contentArea").appendChild(anode);
        }

    }
    function defaultOpen() {
      var asyncRequest;
      var url = "getclothes.php";

      try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open('GET', url, true);
        asyncRequest.send(null);
      } catch (exception) {
        alert("Ajax request failed")
      }

      function stateChange() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            var myObj = JSON.parse(this.responseText);
            createCloset(myObj);

        }
      }
    }
    function clickShirt() {
      console.log("hello")
      var asyncRequest;
      var url = "getclothes.php?type=shirt";
      try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open('GET', url, true);
        asyncRequest.send(null);
      } catch (exception) {
        alert("Ajax request failed")
      }

      function stateChange() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            var myObj = JSON.parse(this.responseText);
            createCloset(myObj);

        }
      }
    }
    function clickPants() {
      var asyncRequest;
      var url = "getclothes.php?type=pants";
      try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open('GET', url, true);
        asyncRequest.send(null);
      } catch (exception) {
        alert("Ajax request failed")
      }

      function stateChange() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            var myObj = JSON.parse(this.responseText);
                        createCloset(myObj);
        }
      }
    }
    function clickShoes() {
      var asyncRequest;
      var url = "getclothes.php?type=shoes";
      try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open('GET', url, true);
        asyncRequest.send(null);
      } catch (exception) {
        alert("Ajax request failed")
      }

      function stateChange() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            var myObj = JSON.parse(this.responseText);
                        createCloset(myObj);
        }
      }
    }
    function clickAcc() {
      var asyncRequest;
      var url = "getclothes.php?type=accessories";
      try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.onreadystatechange = stateChange;
        asyncRequest.open('GET', url, true);
        asyncRequest.send(null);
      } catch (exception) {
        alert("Ajax request failed")
      }

      function stateChange() {
        if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
            var myObj = JSON.parse(this.responseText);
                        createCloset(myObj);
        }
      }
    }




   document.addEventListener("DOMContentLoaded",init)
   document.addEventListener("DOMContentLoaded", defaultOpen);
   function init(){


      document.getElementById("shirtBtn").addEventListener("onclick", clickShirt);

    document.getElementById("pantsBtn").addEventListener("onmouseenter", clickPants);
      document.getElementById("shoeBtn").addEventListener("onmouseenter", clickShoes);
      document.getElementById("accBtn").addEventListener("onmouseenter", clickAcc);


   }

   function addWear(id){
     var asyncRequest;
     var url = "updateClothes.php?id="+ id ;
     try {
       asyncRequest = new XMLHttpRequest();
       asyncRequest.onreadystatechange = stateChange;
       asyncRequest.open('GET', url, true);
       asyncRequest.send(null);
     } catch (exception) {
       alert("Ajax request failed")
     }

     function stateChange() {
       if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
          console.log(this.responseText)
       }
     }
   }



  </script>

</head>
<body>
  <!-- include in every page! (begin)-->
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <ul class="nav navbar-nav">
          <!-- contains hamburger icon dropdown-->
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button">
              <span class="glyphicon glyphicon-menu-hamburger"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="my_clothes.php">My Closet</a></li>
              <li><a href="my_outfits.php">My Outfits</a></li>
              <li><a href="busformal.html">Advice</a></li>
              <li><a href="history.html">History</a></li>
            </ul>
          </li>
        </ul>
        <!-- Clothes Doors title banner-->
        <div class="navbar-header">
          <a class="navbar-brand" src="menu.png" id="header" href="home.html">Clothes Doors</a>
        </div>
        <div id="welcome">
          <?php
            echo "Hello $fname $lname!";
           ?>
        </div>
      </div>
    </nav>
  <!-- include in every page (end) -->

  <!-- header for page-->
  <div>
    <h1 id="head">My Closet</h1>
  </div>
  <div class="listhold">
    <div class="listbox">
      <ul class="list-group">
        <li class="list-group-item" id="shirtBtn" onclick="clickShirt()">Shirts</a></li>
        <li class="list-group-item" id="pantsBtn" onclick="clickPants()" >Pants</li>
        <li class="list-group-item" id="shoeBtn"onclick="clickShoes()" >Shoes</li>
        <li class="list-group-item" id="accBtn" onclick="clickAcc()" >Accessories</li>
        <li class="list-group-item"><a href="my_outfits.php">My Outfits</a></li>
      </ul>
    </div>
    <div class="listbox">
      <ul class="list-group">
        <li class="list-group-item"><a href="create_test.php">Upload Clothes</a></li>
        <li class="list-group-item"><a href="delete.php">Delete Clothes</a></li>
        <li class="list-group-item"><a href="analyze.html">What's In My Closet?</a></li>
      </ul>
    </div>
  </div>

  <!-- display clothes begin-->
  <div class="row" id="contentArea">

  </div>
</body>
</html>
