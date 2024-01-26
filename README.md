# 自製框架

### 功能特點
1. Helper Functions: 定義了許多方便且可能會經常被使用的 Functions。
2. Error Handler: 實現錯誤處理機制，自動偵測錯誤，在錯誤產生時，自動將錯誤資訊寫入 Log 記錄檔。
3. Exception Handler: 實現例外處理機制，自動偵測例外，在例外產生時，自動將例外資訊寫入 Log 記錄檔。
4. Autoloader: class、interface、trait、enum 的 Namespace 採用 PSR-4 命名，搭配 Autoloader 則可在每次類別存取時，自動將所需檔案引入。
5. Routes: 讓開發者可根據需求自行定義所需路由。