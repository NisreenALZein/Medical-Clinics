<!-- زر الترجمة -->
<button onclick="translatePage()" 
        style="position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 500; background: white; padding: 10px 14px; border-radius: 50px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); font-size: 16px;">
    🌐 translatePage
</button>

<!-- عنصر Google Translate (مخفي بالبداية) -->
<div id="google_translate_element" style="display:none; position: fixed; bottom: 4.5rem; right: 1.5rem; background:white; border:1px solid #ddd; padding:6px; border-radius:8px; z-index:600;"></div>

<script>
    function translatePage() {
        // إذا ما تم تحميل Google Translate بعد
        if (!window.googleTranslateLoaded) {
            var script = document.createElement('script');
            script.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
            document.head.appendChild(script);
            window.googleTranslateLoaded = true;
        } else {
            // إظهار/إخفاء قائمة اللغات
            const el = document.getElementById("google_translate_element");
            el.style.display = (el.style.display === "none" ? "block" : "none");
        }
    }

    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en', // غيّرها للغتك الأساسية مثلاً 'ar'
            includedLanguages: 'ar,en,fr,de,es', // حدد اللغات اللي بدك تترجم إلها
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');

        // أول مرة بعد التحميل يظهر القائمة
        document.getElementById("google_translate_element").style.display = "block";
    }
</script>