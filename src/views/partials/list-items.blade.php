<?php
$unique_to = isset($unique_to) ? $unique_to : '';
if($unique_to){
  $toParse = \Codiiv\Taxonomies\Models\Taxonomies::loadUnique($taxonomy, $unique_to, $page);
}else{
  $page = isset($_GET['page']) ? $_GET['page'] : 1;
  $toParse = $Taxonomy::sortedTermsPaginated($taxonomy, $page);
}
?>
<ul class="the-items">
  <form class="delete-taxonomy-term" action="{{ url( \Config::get('taxonomies.taxonomy_path').'/delete/taxonomy' ) }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}"> <?php //<meta name="csrf-token" content="{{ csrf_token() }}"> ?>
    <input type="hidden" name="tobedeleted" value=""> <?php //<meta name="csrf-token" content="{{ csrf_token() }}"> ?>
    <input type="hidden" name="taxonomy" value="{{ $taxonomy }}"> <?php //<meta name="csrf-token" content="{{ csrf_token() }}"> ?>
  <?php if(isset($_GET['page'])){ ?>
    <input type="hidden" name="page" value="{{ $_GET['page'] }}">
  <?php } ?>
    <input type="hidden" name="unique_to" value="{{ $unique_to }}">

  </form>

  @foreach($toParse as $key => $term )
  <li data-value="{{ $term->id }}" class="level-{{ $term->level }} @if((isset($term_exists) && $term_exists) && $the_term->id == $term->id) beingedited @endif">
    <a href="{{ url()->current().'?taxonomy='.$taxonomy.'&term_id='.$term->id }}<?php if(isset($_GET['page'])) echo '&page='.$_GET['page']; ?>"><span class="tax-color" style="background-color:{{ $term->color }}"></span> {{ $term->pointer.' '.$term->name }} <span class="theslug">[ {{ $term->slug }} ]</span></a>
    <div class="taxonomies-actions" style="display:none">
      <button type="button" name="button" class="btn-button disable-taxonomy btn-normal" disabled>{{ __("Disable") }}</button><button type="button" name="button" class="btn-button btn-dangerous delete-taxonomy" data-termid="{{ $term->id }}">{{ __("Delete") }}</button>
    </div>
  </li>
  @endforeach
</ul>
<div class="pagination-container">
  {{ $toParse->links() }}
</div>
