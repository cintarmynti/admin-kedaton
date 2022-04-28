importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyDExuTu6H1H2Cq8_sz8yHzNM0XsGbZJ-uQ",
    projectId: "kedaton-e6eb7",
    messagingSenderId: "133991064317",
    appId: "1:133991064317:web:9a5db01764c1fb4a5bd494"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
