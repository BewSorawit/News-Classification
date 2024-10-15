
from fastapi import APIRouter, Depends, HTTPException, status
from requests import Session
from crud.news_type import getAll
from schemas.news_type import NewsTypeResponse
from routers.user_permissions import get_editor_user
from utils.auth import get_current_user
from database import get_db

router = APIRouter()


@router.get('/', response_model=list[NewsTypeResponse], status_code=status.HTTP_200_OK)
def get_all_news_types(db: Session = Depends(get_db),
                       current_user: dict = Depends(get_current_user)):
    get_editor_user(db, current_user)
    news_types_all = getAll(db)
    return news_types_all