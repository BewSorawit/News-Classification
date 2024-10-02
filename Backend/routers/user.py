from fastapi import APIRouter, Depends
from sqlalchemy.orm import Session
from database import get_db
from schemas.users import User, UserCreate
from crud.users import create_user
router = APIRouter()


@router.post("/users/", response_model=User)
def create_new_user(user: UserCreate, db: Session = Depends(get_db)):
    return create_user(db=db, user=user)
