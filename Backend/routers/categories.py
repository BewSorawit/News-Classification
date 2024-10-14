
from fastapi import APIRouter, Depends, HTTPException, status
from requests import Session
from crud.categories import fetch_category_by_id
from routers.user_permissions import get_viewer_user
from utils.auth import get_current_user
from database import get_db
from schemas.category import CategoryResponse

router = APIRouter()


@router.get('/{categories_id}', response_model=CategoryResponse, status_code=status.HTTP_200_OK)
def get_category_item_by_id(
    categories_id: int,
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_viewer_user(db, current_user)
    category = fetch_category_by_id(db, categories_id)
    return category
