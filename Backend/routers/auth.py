from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from utils.auth import verify_password, create_access_token, create_refresh_token
from schemas.token import Token
from schemas.users import UserLogin
from database import get_db
from models.user import User

router = APIRouter()


@router.post("/login", response_model=Token)
def login_for_access_token(user_login: UserLogin, db: Session = Depends(get_db)):

    user = db.query(User).filter(User.email == user_login.email).first()

    if not user or not verify_password(user_login.password, user.password):
        raise HTTPException(
            status_code=status.HTTP_401_UNAUTHORIZED,
            detail="Incorrect email or password",
            headers={"WWW-Authenticate": "Bearer"},
        )

    access_token = create_access_token({"sub": user.email})
    refresh_token = create_refresh_token({"sub": user.email})

    return Token(
        access_token=access_token,
        refresh_token=refresh_token,
        token_type="bearer"
    )
