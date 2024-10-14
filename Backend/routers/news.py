from typing import Optional
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from routers.user_permissions import get_editor_user, get_viewer_user, get_writer_user
from utils.auth import get_current_user
from schemas.news import NewsCreatedResponse, NewsCreate, NewsUpdate, NewsUpdateResponse, NewsResponse
from database import get_db
from crud.news import writerGetAll, create_news, update_news, getAll, getNewsById ,getByType

router = APIRouter()


@router.get('/{news_id}', response_model=NewsResponse)
def get_news_by_id_item(
    news_id: int,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_viewer_user(db, current_user)
    news = getNewsById(db, news_id)
    return news


@router.get('/', response_model=list[NewsResponse])
def get_all_news_item(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_viewer_user(db, current_user)
    news_all = getAll(db)
    return news_all

@router.get('/type/{status}', response_model=list[NewsResponse])
def get_news_type_item(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_editor_user(db, current_user)
    news_all = getByType(db)
    return news_all




@router.post('/', response_model=NewsCreatedResponse, status_code=status.HTTP_201_CREATED)
def create_news_item(
    news: NewsCreate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    writer_id = get_writer_user(db, current_user)

    created_news = create_news(db, news, writer_id)

    if not created_news:
        raise HTTPException(status_code=status.HTTP_400_BAD_REQUEST,
                            detail="Failed to create news item.")

    return NewsCreatedResponse(success=True, data=created_news)


@router.put('/{news_id}', response_model=NewsUpdateResponse)
def update_news_item(
    news_id: int,
    news_update: NewsUpdate,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    editor_id = get_editor_user(db, current_user)
    updated_news = update_news(db, news_id, news_update, editor_id)

    return NewsUpdateResponse(success=True, data=updated_news)


@router.get('/writer/', response_model=list[NewsResponse])
def writer_get_all_news_item(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    writer_id = get_writer_user(db, current_user)
    news_all = writerGetAll(db, writer_id=writer_id)
    return news_all
