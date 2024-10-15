from typing import List
from fastapi import APIRouter, Depends, HTTPException, status
from sqlalchemy.orm import Session
from crud.typer_user import get_role_user_login, get_typer_user
from schemas.typer_user import TyperUserBase, TyperUserResponse
from routers.user_permissions import get_admin_user
from utils.auth import get_current_user
from database import get_db

router = APIRouter()


@router.get('/', response_model=List[TyperUserResponse])
def get_all_typer_user(
    db: Session = Depends(get_db),
    current_user: dict = Depends(get_current_user)
):
    get_admin_user(db, current_user)
    typer_users = get_typer_user(db)

    if not typer_users:
        raise HTTPException(status_code=204, detail="No users found")

    return typer_users


@router.get("/role", response_model=TyperUserBase)
def get_user_role(db: Session = Depends(get_db), current_user: dict = Depends(get_current_user)):
    role = get_role_user_login(db, current_user)

    if role is None:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND,
                            detail="User not found or role not assigned")

    return {"role": role}


@router.get("/role", response_model=TyperUserBase)
def get_user_role(db: Session = Depends(get_db), current_user: dict = Depends(get_current_user)):
    role = get_role_user_login(db, current_user)

    if role is None:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND,
                            detail="User not found or role not assigned")

    return {"role": role}


@router.get("/role", response_model=dict)
def get_user_role(db: Session = Depends(get_db), current_user: dict = Depends(get_current_user)):
    role = get_role_user_login(db, current_user)

    if role is None:
        raise HTTPException(status_code=status.HTTP_404_NOT_FOUND,
                            detail="User not found or role not assigned")

    return {"role": role}