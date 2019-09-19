# method pomidora
Method pomidora - web app for effectively perform tasks based on [Pomodoro technique](https://en.wikipedia.org/wiki/Pomodoro_Technique).

Demo with russian localization: [https://method-pomidora.ru](https://method-pomidora.ru).
<br><br>

## Software
- Backend
  - `Laravel`
  - `MySQL`
- Frontend
  - `Vue.js`
  - `Vuex`
  - `laravel-mix`
  - `bootstrap`
  
<br>

## Functionality
#### Main app.
- Timer for task execution. 3 modes: work time, rest and long rest.
- Add, edit, remove tasks.
- Recovery last mode, pomidor number and active tasks on page reload.
<br><br>
![Main app work time](/screens/main-app-work-time.png)
---
![Main app rest time](/screens/main-app-rest-time.png)
<br><br>

#### Completed tasks.
- All completed tasks are saved on a server, if user is authorized.
- Browsing tasks with date filter possibility. 
<br><br>
![Completed tasks](/screens/completed-tasks.png)
<br><br>

#### Settings for authorized users.<br><br>
![Settings](/screens/settings.png)
<br><br>

#### Authorization.
- Supported 3 types authorization.
  - Common with registration.
  - Via vk account.
  - Via gmail account.
<br><br>
![Authorization](/screens/auth.png)
