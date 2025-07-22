// 既存のコード：bootstrapの読み込み
import './bootstrap';

// ✅ jQueryを読み込み（npm install jquery が必要）
import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// ✅ Alpine.js の設定
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();