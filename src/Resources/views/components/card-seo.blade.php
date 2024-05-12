<fieldset>
    <legend class="toggle">SEO</legend>
    <div class="toggable">
        <x-aboleon-framework::translatable-tabs :model="$model" datakey="seo" :fillables="$model->seoColumns()" />
    </div>
</fieldset>
