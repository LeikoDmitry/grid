Plugin for the WordPress
========================

Installation:
-------------
Go to your plugin directory and the clone via git:

```bash
$ cd /worpress-path/wp-content/plugins
$ git clone https://github.com/LeikoDmitry/grid.git category-grid
```
Next need to activate in the admin area. Now you can add short code on pages or posts.

Usage:
------
```
[dm-grid order=DESC columns=2]

[dm-grid order=DESC columns=4 taxonomy=category]

[dm-grid order=ASC taxonomy=custom_category orderby=name_or_some_custom_field]
```

