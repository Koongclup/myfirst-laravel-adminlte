<div id="loading-overlay">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

<style>
    /* Styling for loading overlay */
    #loading-overlay {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    /* Spinner customization */
    .spinner-border {
        width: 3rem;
        height: 3rem;
        border-width: .25em;
    }
</style>

<script>
    window.addEventListener('load', function() {
   setTimeout(function() {
       var overlay = document.getElementById('loading-overlay');
       overlay.style.display = 'none';
   }, 1500);  
});
</script>