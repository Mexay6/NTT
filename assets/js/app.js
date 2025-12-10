// small JS for front-end interactions
document.addEventListener('DOMContentLoaded', function(){
    // handle redirect after login if present
    const params = new URLSearchParams(window.location.search);
    if(params.get('redir')){
        // do nothing here; server handles redirection after login
    }
});
