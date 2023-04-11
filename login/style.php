<style>
img {
  border-radius: 50px;
  border: 5px solid white;
  box-shadow: 15px 15px 1px #4B0082;
}
table {
    margin: auto;
    border-collapse: collapse;
    box-shadow: 15px 15px 1px #4B0082;
    width: 80%;
    background-color: white;
    margin-bottom: 80px;
  }
  th, td {
    padding: 18px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    font-family:verdana;
  }
  th {
    background-color: black;
    color: white;
  }
  .players-button {
    background-color: #FFD524;
    border: none;
    color: black;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
  }
  .players-button:hover {
    background-color: #ECB602;
  }
  .players-button:focus {
    outline: none;
    box-shadow: 0px 0px 5px #4CAF50;
  }
  .form-button {
    display: block;
    margin: 0 auto;
    background-color: #FFD524;
    color: black;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    margin-bottom: 50px;
    box-shadow: 8px 8px 1px #4B0082;
  }
  .form-button:hover {
    background-color: #ECB602;
  }
  .form-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
    display: none;
  }
  .form-popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    border-radius: 25px;
    z-index: 2;
    display: none;
  }
  .form-container {
    max-width: 400px;
  }
  .form-container input[type=date],
  .form-container input[type=time],
  .form-container input[type=text] {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  .form-container button[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  .form-container button[type=submit]:hover {
    background-color: #3e8e41;
  }
  .form-container .btn.cancel {
    background-color: #f44336;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  .form-container .btn.cancel:hover {
    background-color: #cc2e2e;
  }
  .form-container h1 {
    text-align: center;
    font-family:verdana;
    font-size:25px;
  }
  select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  select:focus {
    outline: none;
    border-color: #2ecc71;
  }
  .result-button {
    background-color: #FFD524;
    border: none;
    color: black;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease;
  }
  .result-button:hover {
    background-color: #ECB602;
  }

  .logout-button {
    background-color: red; 
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    position: fixed;
    bottom: 20px;
    right: 20px;
}
  .logout-button:hover {
    background-color: darkred;
  }
  
  .logout-button:focus {
    outline: none;
    box-shadow: none;
  }
  .filter-form {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    margin: 20px 0;
  }
  .filter-form select {
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #008CBA;
    }
  .filter-form label {
    font-size: 18px;
    margin-right: 10px;
  }
  .filter-form input[type=text] {
    font-size: 16px;
    padding: 10px;
    border-radius: 5px;
    border: 2px solid #008CBA;
  }
  .filter-form input[type=date] {
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }
  .filter-form button[type=submit] {
    background-color: #FFD524;
    color: black;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    margin-left: 10px; 
    margin-right: 20px;
    font-size: 16px;
    cursor: pointer;
  } 
  .filter-form button[type=submit]:hover {
    background-color: #ECB602;
  }
  .filter-form input[type=date]:focus {
    outline: none;
    border-color: #2980b9;
  }
  div {
    display: flex;
    justify-content: center;
    align-items: center;
    padding-top: 30px;
  }
  .box{
    margin-left: auto;
		margin-right: auto;
    width: 1300px;
    height: 80px;
    top: 10%;
    left: 50%;
    text-align: center;
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 15px 15px 1px #4B0082;
    background-color: #f9f9f9;
    margin-bottom: 80px;

  }
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }
  .color-square {
    display: inline-block;
    height: 20px;
    width: 40px;
    background-color: red;
    border-radius: 5px;
  }
</style>"