<!DOCTYPE html>
<html lang="ms">
<head>
<meta charset="UTF-8">
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: Arial, sans-serif; font-size: 11pt; color: #1a1a2e; line-height: 1.6; }
    .cover { text-align: center; padding: 60px 40px 40px; border-bottom: 3px solid #6c63ff; }
    .cover img { width: 90px; margin-bottom: 18px; }
    .cover h1 { font-size: 20pt; font-weight: 800; color: #1a1a2e; margin-bottom: 6px; }
    .cover h2 { font-size: 14pt; font-weight: 600; color: #6c63ff; margin-bottom: 4px; }
    .cover p  { font-size: 9pt; color: #888; margin-top: 10px; }
    .cover .badge { display: inline-block; background: #6c63ff; color: #fff; border-radius: 20px; padding: 4px 16px; font-size: 9pt; margin-top: 14px; }
    .section { padding: 24px 40px 0; }
    .section h3 { font-size: 13pt; font-weight: 700; color: #6c63ff; border-left: 4px solid #6c63ff; padding-left: 10px; margin-bottom: 12px; margin-top: 24px; }
    .section h4 { font-size: 11pt; font-weight: 700; color: #1a1a2e; margin: 14px 0 6px; }
    .section p, .section li { font-size: 10pt; color: #333; margin-bottom: 5px; }
    .section ul, .section ol { padding-left: 20px; margin-bottom: 10px; }
    .step { background: #f8f8ff; border: 1px solid #e0deff; border-radius: 6px; padding: 10px 14px; margin-bottom: 8px; }
    .step strong { color: #6c63ff; }
    .note { background: #fff8e1; border-left: 4px solid #ffc107; padding: 8px 12px; margin: 10px 0; font-size: 9.5pt; border-radius: 0 6px 6px 0; }
    .coming-soon { background: #fff3cd; border: 2px dashed #ffc107; border-radius: 8px; padding: 18px 22px; margin: 20px 0; text-align: center; }
    .coming-soon h3 { color: #856404; font-size: 13pt; border: none; padding: 0; margin-bottom: 6px; }
    .coming-soon p { color: #856404; font-size: 10pt; }
    .footer { text-align: center; padding: 18px 40px; border-top: 1px solid #e0deff; margin-top: 30px; font-size: 8pt; color: #aaa; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 9.5pt; }
    table th { background: #6c63ff; color: #fff; padding: 7px 10px; text-align: left; }
    table td { padding: 6px 10px; border-bottom: 1px solid #eee; }
    table tr:nth-child(even) td { background: #f8f8ff; }
</style>
</head>
<body>
@yield('content')
</body>
</html>
