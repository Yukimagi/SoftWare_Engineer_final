網頁PHP說明： 
----------------------------------
首頁相關PHP：  
- index.php：登入前的首頁，也就是訪客用的首頁
- loginindex.php：登入頁面，輸入帳號密碼的地方
- loginprocess.php：輸入帳號密碼後，進行SQL查詢的中繼頁面
- lobby.php：登入後的首頁，也就是四種身分的使用者使用的RMS系統首頁
- logoutprocess.php：按下登出後，進行session銷毀的中繼頁面
- ApplyAccount.php：帳號申請頁面，讓訪客可以向管理員提出想申請帳號的意願(主要為成為房東)
- applyprocess.php：填寫完後帳號申請表後，進行SQL查詢的中繼頁面

後台相關PHP：
- - 帳戶總覽相關
- SAS.php：所有一般使用者帳戶總覽的頁面
- SAS_UserDetails.php：在帳戶總覽葉面上點選某使用者帳號後，可以顯示該帳戶資料的頁面
- SAS_SQLUpdate.php：
- - 個人帳戶資料修改相關
- SAS_MineUserDetails.php：
- SAS_SQLCreateForMassive.php：
- - 新增帳戶相關
- SAS_CreateAccountChoice.php：
- SAS_CreateAccount.php：
- SAS_SQLCreate.php：
- - 新增大量帳戶相關
- SAS_CreateMassiveAccountChoice.php：
- SAS_SQLMassiveCreate.php：
- SAS_CreateMassiveAccount.php：
- - 刪除帳戶相關
- SAS_UserDelete.php：
- SAS_SQLDelete.php：
- - 修改帳戶權限相關
- SAS_UserPermissionEdit.php：
- SAS_SQLPermissionEdit.php：
----------------------------------

更新紀錄  
24/05/11  
----------------------------------
Feat:
- 建構"帳戶資訊總覽"、"帳戶資料編輯"功能
- 建構"新增單一使用者帳戶"功能  
- 建構"新增大量使用者帳戶"功能
- 建構"刪除使用者帳戶"功能

Modifiy:
- 訪客首頁與使用者首頁調整設計
- 登入/登出系統重製

Fix:  
- 無
  
Docs:  
- 更新README.md

24/05/17
----------------------------------
Feat:
- 建構"帳戶訪問權限控制"功能
- 建構"新使用者註冊"功能

Modify:
- 部分iframe頁面與js函式修正

Fix:
- 修正"新增大量使用者後，帳戶總覽顯示錯誤"的問題
- 修正"個人資料修改後，函式呼叫錯誤"的問題
- 修正"部分頁面點擊連結後，導向錯誤頁面"的問題

Style:
- 調整部分程式碼與註解區塊

Refactor:
- 調整SAS系列PHP檔案的目錄分層與導航路徑

Docs:
- 更新部分PHP檔案的用途說明
- 更新README.md
