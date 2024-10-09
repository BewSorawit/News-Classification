from fastapi import FastAPI
from database import engine, Base
from models.user import User
from models.news import News
from models.typer_user import TyperUser
from models.news_type import NewsType
from routers.admin import router as admin_router
from routers.auth import router as auth_router
from routers.news import router as new_router

import uvicorn

app = FastAPI()

Base.metadata.create_all(bind=engine)


app.include_router(admin_router, prefix='/users', tags=['users'])
app.include_router(new_router, prefix='/news', tags=['news'])
app.include_router(auth_router)

if __name__ == "__main__":
    uvicorn.run("main:app", port=8000, log_level="info", reload=True)
