# CASHBOOKAPP 

## 概要
家計簿アプリ

## アプリURL
https://oviwan.xsrv.jp/

## アプリ作成の動機
三日坊主になりがちな家計簿記帳を習慣化する為、自作が有効と判断し、作成しました。

## 主な機能の紹介

|login画面|register画面|  
| :---- | :---- |
| <img width="520" alt="login_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/f8610b7d-83e9-4833-8606-c1998978265c">|<img width="503" alt="register_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/661a05ca-f077-4ac4-a552-9fe644d6f8ec">|
|バリデーションエラーテキスト日本語化|バリデーションエラーテキスト日本語化|

| item index画面 | item index画面（category selectbox表示）|
| :---- | :---- |
|<img width="796" alt="item_index" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/919f893a-8add-4a7d-b653-41864a20fdf2">|<img width="437" alt="item_index_category_select" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/14ab13ac-7b7b-48ff-b9d7-dd0a0a77ae1b">|
|＊ ALL CATEGORYボタンの設置<br>Aをクリックすると、カテゴリー別合計がリセットされ、全合計へと戻る<br><br> ＊ selectedPeriodの状態管理にvuexを使用<br>Bの削除ボタン、追加ボタン、編集ボタンをクリックするとそれぞれの機能が動作するが、クリックしたindexの年月ページにリダイレクトするようクリック時のselectedPeriodをstateとして保持させ、保持したページにリダイレクトさせる為にvuexを使用<br><br>＊ C支出合計金額表示<br>選択した年月もしくはcategory別の支出合計金額を表示<br><br>＊ D滞在ページのマーク表示<br>現在滞在中なのは、どのページなのかをアンダーマークで表示<br><br>＊ Eログインユーザー名を表示<br>ユーザー名もしくは矢印をクリックでプロファイルとログアウトリンクを表示|＊ categoryごとの支出一覧表示<br>categoryセレクトボックスから選択したcategoryの支出項目一覧と合計金額を表示される|

| item index画面(selectedPeriod index) |create item画面|
| :---- | :---- |
|<img width="496" alt="item_index_selectedPeriod" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/2acfc26c-fefc-4a5d-b3a4-c48dccc5c5d8">|<img width="389" alt="create_item_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/71e1cf9b-1dec-48b9-a19c-8e98631f4dd0">|
|＊ selectedPeriodセレクトボックス<br>収支（item）が存在する年月（selectedPeriod）の一覧を表示し、年月を選択すると支出一覧と合計金額が表示される|バリデーションエラーテキスト日本語化<br><br>＊ RETURNボタンを設置<br>create、edit各ページに設置。クリックでitem_indexもしくはcategory_indexページへ遷移|

|create item画面（category selectbox表示）|create item画面（date カレンダー表示）|
| :---- | :---- |
|<img width="480" alt="create_item_category_select" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/5695135b-7c15-4187-b2e1-1931112c8bac">|<img width="431" alt="create_item_date_calender" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/1d74097d-640b-4150-8a8f-628e02136945">|
|支出項目追加の際は、categoryはセレクトボックスから選択する|支出項目追加の際は、支出日（date）はカレンダーから選択する|

|create category画面とedit category画面|
| :---- |
|<img width="615" alt="create_category_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/dced705b-86bd-4775-b3c9-c036e663b398"><img width="627" alt="edit_category_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/b7d6d3f3-7713-40a4-8696-83d0d72c1b22">|
|バリデーションエラーテキスト日本語化|

|edit item画面（category selectbox表示）|edit item画面（date カレンダー表示）|
| :---- | :---- |
|<img width="489" alt="edit_item_category_select" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/e317b824-2b91-4ecf-a693-8d1e7af3a9f7">|<img width="479" alt="edit_item_date_calender" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/321367db-1fc2-4ef1-b608-2bfa272a0c03">|
|支出項目編集の際は、categoryはセレクトボックスから選択する|支出項目編集の際は、支出日（date）はカレンダーから選択する|

|edit item画面|
| :---- |
|<img width="551" alt="edit_item_error" src="https://github.com/yuzokanda/cashbookapp/assets/112781298/531f87be-c77f-4fc0-97b5-b71c37443759">|
|バリデーションエラーテキスト日本語化|

## 使用技術

- PHP 8.1
- Laravel 10.10
- Laravel Sail
- Laravel Breeze
- JavaScript
- Vue.js 3.3.4
- vite 4.0.0
- Inertia.js 1.0.12
- vuex 4.0.2
- Tailwind CSS









