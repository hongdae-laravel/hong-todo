# 학습용 Todo 리스트 앱
라라벨 꾸준 코딩 모임 홍대에서 라라벨을 학습하기 위해 만든 프로젝트입니다. 학습을 위해 라라벨 5.2 튜토리얼을 마친 결과물(Todo 리스트)에 기능을 추가합니다.
 
5.2의 튜토리얼을 5.4로 수행했습니다.

## 참여방법
### 오프라인 모임
매주 수요일 오후 7시에 홍대 토즈에 모입니다.(매월 첫째주 월요일 제외) 누구나 참여 가능하며, [모던 PHP 유저 그룹](https://www.facebook.com/groups/655071604594451)에 올라오는 이벤트에 참가 의사를 밝히고 오시면 됩니다.  

### 온라인

#### 코드 추가하기
이 저장소를 포크하시고 개발한 내용을 풀 리퀘스트해주세요.

##### 이 저장소(smartbos/hong-todo)의 업데이트된 내용을 내가 포크한 저장소에 반영하는 방법

이 저장소를 upstream 이라는 이름으로 추가합니다.

```
git remote add upstream https://github.com/smartbos/hong-todo.git
```

upstream 의 변경된 내용을 가져옵니다.

```
git fetch upstream
```

로컬 master 브랜치로 이동합니다.

```
git checkout master
```

upsteam/master를 로컬 master 브랜치로 병합합니다.

```
git merge upstream/master
```

#### 코드 리뷰

[풀 리퀘스트](https://github.com/smartbos/hong-todo/pulls)를 리뷰해주세요.

### 기능 제안
만들어 보고 싶은 기능이 있다면 누구나 아래 문서에 기능을 추가해주세요.

[사공이 많은 할일 목록 애플리케이션 기능 목록](https://docs.google.com/spreadsheets/d/11WQDfvgTCVr6ciEZcNvdnsOWow_m7ygDC9w6EnxbO2g/edit?usp=sharing)

## 앱 설치방법

- 저장소를 클론합니다.
- 의존 패키지 설치
    - composer install
- 구동 환경 설정 파일 복사 
    - cp .env.example .env
    - 복사 후엔 자신의 환경에 맞게 .env를 수정하세요.
- 키 생성
    - php artisan key:generate
- 데이터베이스 마이그레이션
    - php artisan migrate

## 후원
라라벨 꾸준 코딩 모임은 XE가 후원해주고 있습니다.