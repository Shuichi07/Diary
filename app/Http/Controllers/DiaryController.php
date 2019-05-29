<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Diary;
use App\Http\Requests\CreateDiary;
use Illuminate\Support\Facades\Auth;

// ↑require_once('別のファイル');のイケてる版

class DiaryController extends Controller
{
    public function index() {
    	// dd('Hello Laravel');
    	// dump and die関数というLaravelに用意された関数
    	// var_dumpとdieを組み合わせたもの
    	// Laravel開発の必須ツールです

        $diaries = Diary::with('likes')->orderBy('id', 'desc')->get();
        // dd($diaries->likes->count());

    	return view('diaries.index', ['diaries' => $diaries]);
    	// view関数はresources/views/内にあるファイルを取得する関数
    	// view('ファイル名')もしくは
    	// view('フォルダ名.ファイル名')のように記述する
    	// 例）view('welcome')
    	// 例）view('diaries.edit')
        // ※ファイル名は.bladeの前のみ
        // view(③, [② => ①]);
    	// ①の変数を、②の変数名に変えて③のviewへ送る。
    }

    public function create() {
        // 投稿画面
    	return view('diaries.create');
    }

    public function store(CreateDiary $request) {
        // 保存処理
        // POST送信データの受け取り
        // $_POSTの代わりにRequestクラスを使用します。
        // INSERT INTO テーブル名 (カラム名) VALUE (値)
        // INSERT INTO diaries (title, body) VALUE ($_POST['title'], $_POST['body'])
        // INSERT INTO diaries (title, body) VALUE ($request->title, $request->body)
        // ModelクラスDiaryを使用する
        $diary = new Diary(); //インスタンス化
        $diary->title = $request->title;
        $diary->body = $request->body;
        $diary->user_id = Auth::user()->id;
        // dd(Auth::user()->name);
        $diary->save();

        // 一覧ページに戻る（リダイレクト処理）
        return redirect()->route('diary.index'); // header()と同じような処理
    }

    public function destroy($id) { // web.phpの'diary/{id}/delete'にある{id}と同名の引数が定義される

        $diary = Diary::find($id);
        // SELECT * FROM diaries WHERE id=?

        $diary->delete();
        // DELETE FROM テーブル名 WHERE id=?

        return redirect()->route('diary.index');
    }

    function edit($id) {
        $diary = Diary::find($id);
        // SELECT * FROM diaries WHERE id=?
        // $diaryはCollectionという型でできていて、Arrayに変換するにはtoArray()

        return view('diaries.edit', ['diary' => $diary]);
    }

    function update($id, CreateDiary $request) {
        $diary = Diary::find($id); // 1件データ取得

        // $requestがバリデーション機能付きの$_POSTみたいなもの
        $diary->title = $request->title; // 値上書き
        $diary->body = $request->body; // 値上書き
        $diary->save(); // 保存

        return redirect()->route('diary.index');
    }

    function mypage() {
        $login_user = Auth::user();
        // dd($login_user->id);
        // whereメッソドを使ったパターン
        $diaries = Diary::where('user_id', 1)->get();
        // where('カラム名', 値);
        // SELECT * FROM diaries WHERE カラム名=値
        // dd($diaries);

        // Modelのリレーションを使ったパターン
        $login_user = Auth::user();
        $diaries = $login_user->diaries;
        // dd($diaries);
        return view('diaries.mypage', ['diaries' => $diaries]);
    }

    function like($id) {
        // idを元にdiaryデータ１件取得
        $diary = Diary::where('id', $id)->with('likes')->first();

        // likesテーブルに選択されているdiaryとログインしているユーザーのidをINSERTする
        $diary->likes()->attach(Auth::user()->id);
        // INSERT INTO likes (diary_id, user_id) VALUES ($diary->id, Auth::user()->id)

        return redirect()->route('diary.index');
    }

}
