var input = document.getElementById("myInput");
var count=1;
if(count==1){
        var conn = new WebSocket('ws://localhost:8080'); 
        count++;
}
input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                                         event.preventDefault();
                                          var pre = document.querySelector("#data-pre");
                                          var pnode = document.createElement("p");
                                          var textnode = document.createTextNode(input.value);
                                          pnode.appendChild(textnode);
                                          pre.appendChild(pnode);
                                          var Data={
                                              'sessionUser':"mayankTiwari@gmail.com",
                                              'secondUser':"shivkumar20592@gmail.com",
                                              'msg':input.value,
                                          }
                                         conn.send(JSON.stringify(Data)); 
                                         conn.onmessage = function(e) {
                                          console.log(e.data);
                                          if(e.data !="null"){
                                                           const obj = JSON.parse(e.data);
                                                              if(obj.msg != "check"){
                                                                 var pre = document.querySelector("#data-pre");
                                                                 var pnode = document.createElement("p");
                                                                 var textnode1 = document.createTextNode(obj.sessionUser);
                                                                 var textnode2 = document.createTextNode('....');
                                                                 var textnode3 = document.createTextNode(obj.msg);
                                                                 pnode.appendChild(textnode1);
                                                                 pnode.appendChild(textnode2);
                                                                 pnode.appendChild(textnode3);
                                                                 pre.appendChild(pnode);
                                                              }
                                                            
                                                            }
                                       };
                                         }
                                                 });

        //  setInterval(function() {
        //     var Datack={
        //         'sessionUser':"mayankTiwari@gmail.com",
        //         'secondUser':"shivkumar20592@gmail.com",
        //         'msg':"check",
        //     }
        //     conn.send(JSON.stringify(Datack));
        //     conn.onmessage = function(e) {
        //            if(e.data !="null"){
        //             const obj = JSON.parse(e.data);
        //              if(obj.msg != "check"){
        //                 var pre = document.querySelector("#data-pre");
        //                 var pnode = document.createElement("p");
        //                 var textnode1 = document.createTextNode(obj.sessionUser);
        //                 var textnode2 = document.createTextNode('....');
        //                 var textnode3 = document.createTextNode(obj.msg);
        //                 pnode.appendChild(textnode1);
        //                 pnode.appendChild(textnode2);
        //                 pnode.appendChild(textnode3);
        //                 pre.appendChild(pnode);
        //              }
                    
        //            }
        //      };
        // }, 5000);
                                                    