<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
    <head>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
        <h2>Welcome, <?php echo $_SESSION['user']; ?> </h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
            <div class="col-lg-12">
                <center><h1>CRUD</h1></center>
                <form  id="formulario"> 
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>  
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>  
                            
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group">
                            <label>telephone</label>
                            <input type="number" class="form-control" id="telephone" name="telephone" required>
                        </div>                           
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="form-control btn btn-success">SAVE</button>
                        </br>
                    </div>
                </form>
                <!-- onClick="validar()"  -->
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Telephone</th>
                        <th>EDITAR</th>
                        <th>ELIMINAR</th>
                    </tr>
                </thead>
                <tbody id="listado"></tbody> 
            </table>
            </div>
        </div>                
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // load the list when start
        cargarLista();        
    });
    
    // Ajax create user
    $("#formulario").submit(function (event) {  
        if(!validar()){
            event.preventDefault();
        }else{                    
            
            var email = $("#email").val();
            let name = $("#name").val();
            let city = $("#city").val();
            let telephone = $("#telephone").val(); 
            $.ajax({        
                url: "./api-rest/create_client.php?email="+email+"&name="+name+"&city="+city+"&telephone="+telephone,
                //url:"./api-rest/create_client.php",
                type:"POST",                
                //data: $(this).serialize(),
                success: function(datos){
                    alert(datos)                  
                },
                error: function(){
                    alert("Error")                   
                }                
            })
        }
    });  
    // function load the list
    function cargarLista(){
        $.ajax({
            url:"./api-rest/get_all_client.php",
            type:"get",
            dataType: "json",
            success: function(datos){
                let contenido = ""; // Variable para almacenar el HTML generado
                console.log(datos);
                datos.forEach(row => {
                contenido += `
                    <tr>
                        <td><input type='text' value='${row.id}' disabled></td>
                        <td><input type='text' value='${row.email}' id='email${row.id}'></td>
                        <td><input type='text' value='${row.name}' id='name${row.id}'></td>
                        <td><input type='text' value='${row.city}' id='city${row.id}'></td>
                        <td><input type='number' value='${row.telephone}' id='telephone${row.id}'></td>
                        <td>
                            <button class='btn btn-warning' onclick='modificar(${row.id})'>Editar</button>
                        </td>
                        <td>
                            <button class='btn btn-danger' onclick='eliminar(${row.id})'>Eliminar</button>
                        </td>
                    </tr>
                    `;
                });
                $("#listado").html(contenido);
            },
            error: function(){
                alert("Error")
            }
        })
    }
    // function upload the list
    function modificar(value){    
        let id = value;               
        var email = $("#email"+value).val();
        let name = $("#name"+value).val();
        let city = $("#city"+value).val();
        let telephone = $("#telephone"+value).val();                 
        $.ajax({           
            url: "./api-rest/update_client.php?id="+id+"&email="+email+"&name="+name+"&city="+city+"&telephone="+telephone+"",
            type: "PUT",
             //url: "./api-rest/update_client.php?id="+value,
            /*
            data:{
                _method: "PUT",
                id: id,
                email: email,
                name: name,
                city: city,
                telephone: telephone
            },       */    
            success: function (respuesta) {
                alert("update")            
            },
            error: function(){
                alert("Error")
            }
        });        
    };
    // function delete the list
    function eliminar(value){    
        if (confirm("¿Estás seguro de eliminar este usuario?")) {           
            $.ajax({
                url: `./api-rest/delete_client.php?id=${value}`,
                type: "DELETE",
                //data: { id: value },
                success: function (respuesta) {
                    alert("delete");
                    cargarLista();
                },
                error: function(){
                    alert("Error")
                }
            });
        }
    };
    // validate fields
    function validar(){        
        let email = $("#email").val();
        let name = $("#name").val();
        let city = $("#city").val();
        let telephone = $("#telephone").val();        
        if(email == null && name == null && city == null && telephone == null){ 
            alert("Debe ingresar todos los datos");
            return false;
        }        
        if (!validarCorreo(email)) {
           alert("The email is not valid.");;
           return false;
        }
        if (name.length < 3) {
            alert("The name must contain at least 3 characters.");
            return false;
        }else if (name.length > 50) {
            alert("The name must contain max 50 characters.");
            return false;
        }

        if (city.length < 3) {
            alert("The city must contain at least 3 characters.");
            return false;
        }else if (city.length > 20) {
            alert("The city must contain max 20 characters.");
            return false;
        }
        return true;
        
    }
    // validate email
    function validarCorreo(email) {
        var regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return regex.test(email);
    }

</script>


    


