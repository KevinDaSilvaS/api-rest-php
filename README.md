# api-rest-php
API REST made with php and mysql, 
to create a user subscribe table,that was my first api rest that included the entire application crud 
and it was very nice and fun to implement it.At the end i learn a lot by finishing this project

<ul>
  <li>400 BAD REQUEST - requisition type not expected or parameters missing.</li>
  <li>500 INTERNAL SERVER ERROR - api for some reason causes an error.The error will be returned.</li>
  <li>201 CREATED - requisition was succesfully accomplished.</li>
  <li>200 OK - list of users returned succesfully.</li>
</ul>

<table>
  <thead>
    <tr>
      <th>Requisition</th>
      <th>Example</th>
      <th>Fields</th>
      <th>Return</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>POST</td>
      <td>http://localhost/api-php/User.php</td>
      <td>{
          "first_name":"another one",
          "last_name":"bites the dust",//optional
          "email":"bittingthedust@gmail.com"
        }</td>
      <td>"New user successfully created."</td>
    </tr>
    <tr>
      <td>GET</td>
      <td>http://localhost/api-php/User.php</td>
      <td></td>
      <td>returns a list with all users</td>
    </tr>
    <tr>
      <td>PUT</td>
      <td>http://localhost/api-php/User.php?id=userid</td>
      <td>{
          "first_name":"another one",
          "last_name":"bites the dust",//optional
          "email":"bittingthedust@gmail.com"
        }</td>
      <td>"User successfully updated."</td>
    </tr>
    <tr>
      <td>DELETE</td>
      <td>http://localhost/api-php/User.php?id=userid</td>
      <td></td>
      <td>"User successfully deleted."</td>
    </tr>
  </tbody>
</table>
