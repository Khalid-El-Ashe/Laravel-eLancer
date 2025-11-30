<div class="form-group">
    <x-form.input label="Category Name" type="text" id="name" name="name" value="{{ $category->name }}" />
</div>
<div class="form-group">
    <x-form.input label="Category Slug" type="text" id="slug" name="slug" value="{{ $category->slug }}" />
</div>
<div class="form-group" style="margin-top: 10px">
    <label for="description">Descirption</label>
    <textarea id="description" name="description"
        class="form-control">{{ old('description', $category->description) }}</textarea>
    @error ('description')
    <p class="text-danger">{{ $errors->first('description') }}</p>
    @enderror
</div>
<div class="form-group" style="margin-top: 10px">
    <x-form.select label="Parent id" id="parent_id" name="parent_id" :options="$parents->pluck('name', 'id')"
        :selected="$category->parent_id" />
</div>
<div class="form-group" style="margin-top: 10px">
    <x-form.input label="Category File" type="file" id="art_path" name="art_path" />
</div>

<div class="form-group" style="margin-top: 10ex">
    <button type="submit" class="btn btn-primary">Save</button>
</div>