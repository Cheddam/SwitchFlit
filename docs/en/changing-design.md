# Changing Design

The core of SwitchFlit can't be tampered with without forking, but you can modify the design and structure of the modal very easily.

The two files you'll want to look at are `css/switchflit.css` and `templates/Includes/SwitchFlit.ss`. The CSS is quite simple and should not be difficult to override as its specificity is purposefully kept low. The HTML contains Vue logic, so you should [read the docs](http://v1.vuejs.org/guide) before making changes here. You can override this template by adding a copy to `mysite/templates/Includes/SwitchFlit.ss`.

This document could be improved in the future with some legitimate examples!
