# Meta Framework
Sub Framework pour Laravel 
### Installation

```bash
composer require aboleon/metaframework`

php artisan vendor:publish --tag=mfw
```
### Utilisation

#### Components
    
```blade
<x-mfw::input name="phone" :value="$data->phone" />
```

### Mediaclass Upload Library
Après une MAJ des fichiers JS ou traduction :
```
php artisan vendor:publish --tag=mfw-mediaclass --force
```