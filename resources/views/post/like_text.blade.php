<strong>
  
<!--繰り返し処理-->
<!--post と　like リレーション-->
@foreach ( $all->likes as $like)
<!--$loop変数-->

<!--配列の要素数が１の場合-->
    @if ( $loop->count == 1 )
      {{ $like->user->name }}が「いいね！」しました
      
<!--繰り返し配列の要素数が1以上、最終配列のユーザー名を表示-->
    @elseif ( $loop->last )
      他
      {{ $like->user->name }}が「いいね！」しました
      
<!--最初の繰り返しでない場合　配列数−１の数にして-->
    @elseif ( !$loop->first )
      他{{ $loop->count - 1 }}人 が「いいね！」しました
 <!--処理中断-->     
    @break
<!--配列の要素数が１以外の場合-->
    @else
      {{ $like->user->name }}, 
    @endif
@endforeach
</strong>