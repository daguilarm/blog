---
extends: _layouts.post
section: content
title: Creando enlaces externos con Javascript de forma dinámica
date: 2019-12-07
description: Enlaces externos con vanilla javascript, de forma dinámica y markdown como formato de texto
categories: [javascript, markdown]
---

Hellow 

```html 
[AnchorCMS](https://anchorcms.com/){.link-out}
```

```javascript
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var linksTargetBlank = document.querySelectorAll('.link-out');
        for (var i = 0; i < linksTargetBlank.length; i++) {
            linksTargetBlank[i].target = "_blank";
        }
    }, false);
</script>
```

