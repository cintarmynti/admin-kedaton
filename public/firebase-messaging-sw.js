importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');

firebase.initializeApp({
    apiKey: "AIzaSyB2OL6IhJX7HDGUblKz0OjCF2tbMvT-tV4",
    authDomain: "kedaton-fbe20.firebaseapp.com",
    projectId: "kedaton-fbe20",
    storageBucket: "kedaton-fbe20.appspot.com",
    messagingSenderId: "201815427799",
    appId: "1:201815427799:web:8dd19acf1353c737abbe92",
    measurementId: "G-96L7Y5B4EG"
});

const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
