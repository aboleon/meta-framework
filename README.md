# Meta Framework
Sub Framework pour Laravel 
### Installation

```bash
composer require aboleon/mfw`

php artisan vendor:publish --tag=mfw
```
### Utilisation

#### Components
    
```blade
<x-mfw::input name="phone" :value="$data->phone" />
```