<style>
.principal {
      min-width: 98vw;
      min-height: 80vh;
      justify-content: center;
}

.menuflex {
      overflow-x: hidden;
      overflow-y: scroll;
      white-space: nowrap;
      height: 90vh;
      justify-content: center;
      margin-left: -30px;
}

.material-icons {
      font-size: 35px;
}

.rotarHorizontal {
      transform: scaleX(-1);
}

.grupo {
      margin: 15px !important;
      justify-content: center;
}

.guardia .card {
      background-color: #1c4086 !important;
}

.bascula .card {
      background-color: #e89440 !important;
}

.menuflex>div {
      display: inline-block;
}

.btn-group {
      margin: 15px;
}

.btn-group .btn {
      margin: 5px;
      border-radius: 10px;
}

.menuflex .card {
      background-color: #5f5f5f;
      color: white;
      margin: 2px;
      font-size: 1.5rem !important;
      padding: 5px;
      padding: 2rem 0;
      /* border: 3px solid green; */
      border: none;
      text-align: center;
      transition: transform 1s;
      max-height: 8rem;
      min-width: 150px;
}

.menuflex .card:hover {
      transform: scale(0.9);
      -webkit-box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);
      -moz-box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);
      box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);

}

.menuflex .card:active {
      transform: scale(0.9);
      -webkit-box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);
      -moz-box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);
      box-shadow: inset 0px 0px 15px 7px rgba(110, 110, 110, 0.64);

}

.sombra {
      -webkit-box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);
      -moz-box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);
      box-shadow: 5px 5px 16px 0px rgba(153, 153, 153, 1);

      border-radius: 10px !important;
      margin-top: 10px;
      padding: 10px;

}


#observaciones {
      width: 100%;
      height: 50px;
}

.item {
      width: 100%;
      height: 3rem;
}

.checked {
      border: solid 1px green !important;
}

.invalid {
      border: solid 2px red !important;
}
</style>