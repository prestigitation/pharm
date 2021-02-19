 function sessionStore(status, title, message) {
     sessionStorage.setItem('status', status.toString());
     sessionStorage.setItem('title', title.toString());
     sessionStorage.setItem('message', message.toString());
 }